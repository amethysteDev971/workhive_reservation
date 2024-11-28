<?php

    namespace App\Enum;
    enum UserRole: string
    {
        case MEMBER = 'member';
        case USER = 'user';
        case ADMIN = 'admin';
    }
