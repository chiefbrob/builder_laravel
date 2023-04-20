<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'description',
        'user_id',
        'shortcode'
    ];

    protected $with = ['teamUsers'];

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

    public function getTasksIdsAttribute()
    {
        $sql = "SELECT id FROM tasks WHERE team_id = ".$this->id. " AND status  != '".Task::DONE ."' AND status != '". Task::CANCELLED . "'";
        $results = DB::select($sql);

        $tasksIds = [];

        foreach ($results as $result) {
            array_push($tasksIds, $result->id);
        }
        return $tasksIds;
    }

}
