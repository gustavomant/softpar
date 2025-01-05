<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTaskAccess;

use App\Enums\AccessType;

class TaskPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return UserTaskAccess::where("user_id", $user->id)
            ->where("task_id", $task->id)
            ->where(function ($query) {
                $query->where("access_type", AccessType::READ)
                    ->orWhere("access_type", AccessType::WRITE);
            })
            ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return UserTaskAccess::where("user_id", $user->id)
            ->where("task_id", $task->id)
            ->where("access_type", AccessType::WRITE)
            ->exists();
    }
}
