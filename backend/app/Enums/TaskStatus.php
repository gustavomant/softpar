<?php

namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = "pending";
    case DONE = "done";
    case REMOVED = "removed";
}
