<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getUserTasks(Request $request)
    {
        $user = $request->user();
        $tasks = $this->taskService->getUserTasks($user->id);
        
        return response()->json($tasks);
    }

    public function getTaskDetails(Request $request, $taskId)
    {
        $user = $request->user();

        $task = $this->taskService->getTaskDetails($user, $taskId);

        return response()->json($task);
    }
    
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        
        $response = $this->taskService->storeTask($user, $validated);

        return response()->json($response, 201);
    }

    public function update(UpdateTaskRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        $task = $this->taskService->updateTask($user, $validated);

        return response()->json($task);
    }
}
