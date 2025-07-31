<?php

namespace App\Enum;

enum UserType: string{
    case ADMIN='Admin';
    case VISITOR = 'Visitor';

}