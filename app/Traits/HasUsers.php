<?php

namespace App\Traits;

use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait HasUsers
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    public function addUser(User $user): bool
    {
        if ($this->hasUser($user)) {
            return true;
        }
        TeamUser::create(
            [
                'user_id' => $user->id,
                'team_id' => $this->id
            ]
        );
        if (!$user->team_id) {
            $user->team_id = $this->id;
            $user->save();
        }
        return true;
    }

    public function removeUser(User $user): bool
    {
        if ($user->id === $this->user->id) {
            return false;
        }

        $teamUser = TeamUser::where('user_id', $user->id)
            ->where('team_id', $this->id)
            ->first();

        return $teamUser->delete();
    }

    public function hasUser(User $user): bool
    {
        $team_id = $this->id;
        $user_id = $user->id;
        $sql = "SELECT id FROM team_users WHERE team_id=$team_id AND user_id=$user_id LIMIT 1";
        $results = DB::select($sql);
        if (count($results) > 0) {
            return true;
        }
        return false;
    }

    public function getMembersIdsAttribute()
    {
        $sql = "SELECT user_id FROM team_users WHERE team_id = ".$this->id;
        $results = DB::select($sql);

        $membersIds = [];

        foreach ($results as $result) {
            array_push($membersIds, $result->user_id);
        }
        return $membersIds;
    }
}