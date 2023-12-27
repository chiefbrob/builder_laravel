<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const OPEN = 'open';
    public const READY = 'ready';
    public const DOING = 'doing';
    public const REVIEWING = 'reviewing';
    public const DONE = 'done';
    public const CANCELLED = 'cancelled';

    public const STATUSES = [
        self::OPEN,
        self::READY,
        self::DOING,
        self::REVIEWING,
        self::DONE,
        self::CANCELLED,
    ];

    protected $fillable = [
        'title',
        'description',
        'team_id',
        'user_id',
        'assigned_to',
        'status',
        'task_id',
        'shortcode'
    ];

    protected $appends = ["openTasks", "subTasks"];

    public static function createFromTemplate(TaskTemplate $template, Team $team, User $user): Task
    {
        $config = $template->toArray();

        $taskData = array_merge(
            $config, 
            ['team_id' => $team->id, 'user_id' => $user->id]
        );

        $task = Task::create($taskData);

        if ($task->team->shortcode) {
            $task->shortcode = $task->team->shortcode . '-' . $task->id;
            $task->save();
        }

        Task::createSubtasksFromConfig($task, $config['config'], $user);

        $task->fresh();

        return $task;
    }

    public static function createSubtasksFromConfig(Task $task, array $config, User $user): void
    {
        if (count($config) > 0) {
            foreach ($config as $taskBlueprint) {
                $taskData = array_merge(
                    $taskBlueprint,
                    [
                        'user_id' => $user->id,
                        'team_id' => $task->team_id,
                        'task_id' => $task->id
                    ]
                );
                $subtask = Task::create($taskData);
                if ($subtask->team->shortcode) {
                    $subtask->shortcode = $subtask->team->shortcode . '-' . $subtask->task_id . '-' . $subtask->id;
                    $subtask->save();
                }

                if (isset($taskBlueprint['tasks'])) {
                    Task::createSubtasksFromConfig(
                        $subtask, 
                        $taskBlueprint['tasks'],
                        $user
                    );
                }
                
                
            }
        }
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAssigneeAttribute()
    {
        if ($this->assigned_to) {
            return User::findOrFail($this->assigned_to);
        }
        return null;
    }

    public function taskStateChanges(): HasMany
    {
        return $this->hasMany(TaskStateChange::class);
    }

    public function getOpenTasksAttribute()
    {
        return Task::where('task_id', $this->id)->where('status', Task::OPEN)->get();
    }

    public function getSubTasksAttribute()
    {
        return Task::where('task_id', $this->id)->get();
    }

}
