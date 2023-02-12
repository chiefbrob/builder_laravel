<?php

namespace App\Traits;

use App\Models\Task;
use App\Models\TaskStateChange;
use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait CanTeamUp
{
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    public function getMyTeamIdsAttribute()
    {
        $sql = "SELECT team_id FROM team_users WHERE user_id = ".$this->id;
        $results = DB::select($sql);

        $myteams = [];


        foreach ($results as $result) {
            array_push($myteams, $result->team_id);
        }

        return $myteams;
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function assignments($status = null)
    {
        $tasks =  Task::where('assigned_to', $this->id);

        if ($status) {
            $tasks->where('status', $status);
        }

        return $tasks->orderBy('id', 'DESC')->paginate();
    }

    public function taskStateChanges(): HasMany
    {
        return $this->hasMany(TaskStateChange::class);
    }

}
