<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait HasRoles {

    /**
     * Users have roles
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    /**
     * Checks if user has a role
     * 
     * @param \App\Models\Role $role BeingChecked
     * 
     * @return bool
     */
    public function hasRole(Role $role): bool
    {
        $role = UserRole::where('user_id', $this->id)
            ->where('role_id', $role->id)->first();
        return $role ? true : false;
    }

    /**
     * Assign a role to user
     * 
     * @param \App\Models\Role $role BeingAssigned
     * 
     * @return bool 
     */
    public function assignRole(Role $role): bool
    {
        if (!$this->hasRole($role)) {
            UserRole::create([
                'role_id' => $role->id,
                'user_id' => $this->id
            ]);
        }
        return true;
    }

    /**
     * Removes a role from user
     * 
     * @param \App\Models\Role $role BeingRemoved
     * 
     * @return bool
     */
    public function removeRole(Role $role): bool
    {
        return UserRole::where('user_id', $this->id)
            ->where('role_id', $role->id)->delete();
        
    }

    public function getRolesListAttribute(): array 
    {
        return DB::table('roles')->whereIn('id', DB::table('user_roles')->where('user_id', $this->id)->pluck('role_id')->all())->pluck('name')->all();
    }
}