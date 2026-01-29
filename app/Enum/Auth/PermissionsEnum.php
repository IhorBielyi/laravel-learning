<?php

namespace App\Enum\Auth;

enum PermissionsEnum: string
{
    case PROFILE_VIEW = 'profile.view';
    case ADMIN_VIEW = 'admin.view';
}
