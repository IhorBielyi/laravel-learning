<?php

namespace App\Enum\Permissions;

enum PermissionsEnum: string
{
    case PROFILE_VIEW = 'profile.view';
    case ADMIN_VIEW = 'admin.view';
}
