<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Subtask;

use App\Models\UserTaskAccess;
use App\Enums\AccessType;

use Illuminate\Auth\Access\AuthorizationException;

class SubtaskService
{
    public function storeSubtask(User $user, array $payload)
    {
        $newSubtask = new Subtask([
            "title" => $payload["title"],
            "subtitle" => $payload["subtitle"],
            "description" => $payload["description"],
            "task_id" => $payload["task_id"],
            "created_by_user_id" => $user->id,
        ]);

        if (!Gate::forUser($user)->allows("create-subtask", $newSubtask)) {
            throw new AuthorizationException("Você não está autorizado a criar esta subtarefa.");
        }

        $newSubtask->save();

        return $newSubtask;
    }

    public function updateSubtask(User $user, array $payload)
    {
        $subtask = Subtask::findOrFail($payload["subtask_id"]);

        if (!Gate::forUser($user)->allows("update-subtask", $subtask)) {
            throw new AuthorizationException("Você não está autorizado a atualizar esta subtarefa.");
        }        

        if (!empty($payload["title"])) {
            $subtask->title = $payload["title"];
        }
        
        if (!empty($payload["subtitle"])) {
            $subtask->subtitle = $payload["subtitle"];
        }
        
        if (!empty($payload["description"])) {
            $subtask->description = $payload["description"];
        }
        
        if (!empty($payload["status"])) {
            $subtask->status = $payload["status"];
        }
        
        $subtask->save();

        return $subtask;
    }
}