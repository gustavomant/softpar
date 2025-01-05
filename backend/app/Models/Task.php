<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\TaskStatus;

class Task extends Model
{
    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class, "task_id")
            ->where("status", "!=", TaskStatus::REMOVED);
    }

    public function setTaskStatusAttribute($value)
    {
        $this->attributes["status"] = TaskStatus::from($value);
    }
}
