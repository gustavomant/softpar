<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserTaskAccessController;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::post("/signin", [AuthenticationController::class, "signIn"]);
Route::post("/signup", [AuthenticationController::class, "signUp"]);

Route::middleware("auth:sanctum")->group(function () {    
    Route::post("/subtask", [SubtaskController::class, "store"]);
    Route::put("/subtask", [SubtaskController::class, "update"]);

    Route::get("/task", [TaskController::class, "getUserTasks"]);
    Route::get("/task/{taskId}", [TaskController::class, "getTaskDetails"]);
    Route::post("/task", [TaskController::class, "store"]);
    Route::put("/task", [TaskController::class, "update"]);

    Route::post("/user-task-access", [UserTaskAccessController::class, "store"]);
});
