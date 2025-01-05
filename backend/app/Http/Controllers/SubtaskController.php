<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreSubtaskRequest;
use App\Http\Requests\UpdateSubtaskRequest;
use App\Services\SubtaskService;

class SubtaskController extends Controller
{
    protected $subtaskService;

    public function __construct(SubtaskService $subtaskService)
    {   
        $this->subtaskService = $subtaskService;
    }

    public function store(StoreSubtaskRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $newSubtask = $this->subtaskService->storeSubtask($user, $validated);
    
        return response()->json($newSubtask, 201);
    }

    public function update(UpdateSubtaskRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $subtask = $this->subtaskService->updateSubtask($user, $validated);

        return response()->json($subtask);
    }
}
