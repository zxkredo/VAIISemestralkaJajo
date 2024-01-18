<?php

namespace App\Helpers;

use App\Models\Login;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UserRole;

class PermissionChecker
{
    public static function isAdmin(Login $login) : bool {
        return UserRole::hasRole($login, Role::getRoleByName('administrator'));
    }
    public static function isRunner(Login $login) : bool {
        return UserRole::hasRole($login, Role::getRoleByName('runner'));
    }
    public static function canDeleteAccount(Login $login) : bool {
        $userRoles = UserRole::getAllRolesOfUser($login);
        foreach ($userRoles as $role)
        {
            if (RolePermission::hasRolePermission($role, Permission::getPermissionByName('deleteAccount')))
            {
                return true;
            }
        }
        return false;
    }

}