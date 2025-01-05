<?php

namespace App\Enums;

enum AccessType: string
{
    case READ = "read";
    case WRITE = "write";
}
