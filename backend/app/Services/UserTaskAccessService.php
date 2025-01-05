<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
use App\Models\UserTaskAccess;
use App\Models\User;

use Illuminate\Auth\Access\AuthorizationException;

class UserTaskAccessService
{
    public function storeUserTaskAccess(User $user, array $payload)
    {
        $targetUser = User::where("email", $payload["user_email"])->firstOrFail();
        
        $newTaskAccess = new UserTaskAccess([
            "task_id" => $payload["task_id"],
            "user_id" => $targetUser->id,
            "access_type" => $payload["access_type"],
        ]);

        if (!Gate::forUser($user)->allows("create-user-task-access", $newTaskAccess)) {
            throw new AuthorizationException("Você não está autorizado a criar este acesso à tarefa do usuário.");
        }

        $newTaskAccess->save();

        return $newTaskAccess;
    }
}