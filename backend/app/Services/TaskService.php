<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\UserTaskAccess;
use App\Enums\AccessType;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class TaskService
{
    public function getUserTasks(int $userId)
    {
        return Task::query()
            ->join("user_task_accesses", "user_task_accesses.task_id", "=", "tasks.id")
            ->where("user_task_accesses.user_id", $userId)
            ->where("tasks.status", "!=", "removed")
            ->select("tasks.*")
            ->distinct()
            ->get();
    }

    public function getTaskDetails(User $user, int $taskId)
    {
        $task = Task::with("subtasks")->findOrFail($taskId);

        if (!Gate::forUser($user)->allows("view-task", $task)) {
            throw new AuthorizationException("Você não está autorizado a visualizar esta tarefa.");
        }

        return $task;
    }

    public function storeTask(User $user, array $payload)
    {
        $task = new Task();
        $task->title = $payload["title"];
        $task->subtitle = $payload["subtitle"];
        $task->description = $payload["description"];
        $task->due_date = $payload["due_date"];
        $task->created_by_user_id = $user->id;
        $task->save();

        $userTaskAccess = new UserTaskAccess();
        $userTaskAccess->user_id = $user->id;
        $userTaskAccess->task_id = $task->id;
        $userTaskAccess->access_type = "write";
        $userTaskAccess->save();

        return (object) [
            "task" => $task,
            "user_task_access" => $userTaskAccess
        ];
    }

    public function updateTask(User $user, array $payload)
    {
        $task = Task::findOrFail($payload["task_id"]);

        if (!Gate::forUser($user)->allows("update-task", $task)) {
            throw new AuthorizationException("Você não está autorizado a atualizar esta tarefa.");
        }
        
        if (!empty($payload["title"])) {
            $task->title = $payload["title"];
        }
    
        if (!empty($payload["subtitle"])) {
            $task->subtitle = $payload["subtitle"];
        }
    
        if (!empty($payload["description"])) {
            $task->description = $payload["description"];
        }
    
        if (!empty($payload["due_date"])) {
            $task->due_date = $payload["due_date"];
        }
    
        if (!empty($payload["status"])) {
            $task->status = $payload["status"];
        }    

        $task->save();

        return $task;
    }
}