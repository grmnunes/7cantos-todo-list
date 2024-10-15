<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    public function creating(Task $task): void
    {
        $task->user_id = auth()->user()->id;

        if ($task->status) {
            $task->finished_at = now();
        }
    }

    public function updating(Task $task): void
    {
        if (boolval($task->getOriginal('status')) != $task->status) {
            if ($task->status) {
                $task->finished_at = now();
            }
            else {
                $task->finished_at = null;
            }
        }
    }
}
