<?php

namespace App\Traits;

use App\Models\Task;
use App\Models\TaskTemplate;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

trait HasTasks
{
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function taskTemplates(): HasMany
    {
        return $this->hasMany(TaskTemplate::class);
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