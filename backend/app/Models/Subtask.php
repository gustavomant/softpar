<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;

class Subtask extends Model
{
    //
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "task_id",
        "created_by_user_id",
    ];

    public function setTaskStatusAttribute($value)
    {
        $this->attributes["status"] = TaskStatus::from($value);
    }
}
