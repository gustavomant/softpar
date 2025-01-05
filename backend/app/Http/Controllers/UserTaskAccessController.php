<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreUserTaskAccessRequest;
use App\Services\UserTaskAccessService;

class UserTaskAccessController extends Controller
{
    protected $userTaskAccessService;

    public function __construct(UserTaskAccessService $userTaskAccessService)
    {
        $this->userTaskAccessService = $userTaskAccessService;
    }

    public function store(StoreUserTaskAccessRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $newTaskAccess = $this->userTaskAccessService->storeUserTaskAccess($user, $validated);

        return response()->json($newTaskAccess, 201);
    }
}
