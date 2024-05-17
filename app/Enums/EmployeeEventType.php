<?php

namespace App\Enums;

enum EmployeeEventType: string
{
    case CREATE = 'Create';
    case UPDATE = 'Update';
}
