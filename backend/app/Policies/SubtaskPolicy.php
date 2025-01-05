<?php

namespace App\Policies;

use App\Models\Subtask;
use App\Models\User;
use App\Models\UserTaskAccess;
use Illuminate\Auth\Access\Response;

use App\Enums\AccessType;

class SubtaskPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Subtask $newSubtask): bool
    {
        return UserTaskAccess::where("user_id", $user->id)
            ->where("task_id", $newSubtask->task_id)
            ->where("access_type", AccessType::WRITE)
            ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subtask $subtask): bool
    {
        return UserTaskAccess::where("user_id", $user->id)
            ->where("task_id", $subtask->task_id)
            ->where("access_type", AccessType::WRITE)
            ->exists();
    }
}
