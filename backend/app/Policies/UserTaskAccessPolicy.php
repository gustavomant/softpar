<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserTaskAccess;
use Illuminate\Auth\Access\Response;

use App\Enums\AccessType;

class UserTaskAccessPolicy
{
    public function create(User $user, UserTaskAccess $newTaskAccess): bool
    {
        return UserTaskAccess::where("task_id", $newTaskAccess->task_id)
            ->where("user_id", $user->id)
            ->where("access_type", AccessType::WRITE)
            ->exists();
    }
}
