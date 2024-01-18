<?php

namespace App\Helpers;

use App\Models\Login;
use App\Models\Role;
use App\Models\UserRole;

class PermissionChecker
{
    public static function isAdmin(Login $login) : bool {
        return UserRole::hasRole($login, Role::getRoleByName('administrator'));
    }
}