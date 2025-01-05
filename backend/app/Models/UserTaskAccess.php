<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\AccessType;

class UserTaskAccess extends Model
{
    protected $fillable = [
        "task_id",
        "user_id",
        "access_type"
    ];
    
    //
    public function setAccessTypeAttribute($value)
    {
        $this->attributes["access_type"] = AccessType::from($value);
    }
}
