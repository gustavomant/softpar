<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

use App\Policies\SubtaskPolicy;
use App\Policies\UserTaskAccessPolicy;
use App\Policies\TaskPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define("view-subtask",   [SubtaskPolicy::class, "view"]);
        Gate::define("create-subtask", [SubtaskPolicy::class, "create"]);
        Gate::define("update-subtask", [SubtaskPolicy::class, "update"]);
        Gate::define("delete-subtask", [SubtaskPolicy::class, "delete"]);

        Gate::define("create-user-task-access", [UserTaskAccessPolicy::class, "create"]);
    
        Gate::define("view-task",   [TaskPolicy::class, "view"]);
        Gate::define("update-task", [TaskPolicy::class, "update"]);
    }
}
