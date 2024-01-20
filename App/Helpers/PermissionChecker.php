<?php

namespace App\Helpers;

use App\Models\Login;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UserRole;

class PermissionChecker
{
    private static function canPermission(Login $login, string $permissionName) : bool
    {
        $userRoles = UserRole::getAllRolesOfUser($login);
        foreach ($userRoles as $role)
        {
            if (RolePermission::hasRolePermission($role, Permission::getPermissionByName($permissionName)))
            {
                return true;
            }
        }
        return false;
    }
    private static function isRole(Login $login, string $roleName) : bool
    {
        return UserRole::hasRole($login, Role::getRoleByName($roleName));
    }

    public static function isAdmin(Login $login) : bool {
        return static::isRole($login, 'administrator');
    }
    public static function isRunner(Login $login) : bool {
        return static::isRole($login, 'runner');
    }
    public static function canDeleteAccount(Login $login) : bool {
        return static::canPermission($login, 'deleteAccount');
    }

    public static function canCreateRuns(Login $login) : bool
    {
        return static::canPermission($login, 'createRuns');
    }

    public static function canDeleteRuns(Login $login) : bool
    {
        return static::canPermission($login, 'deleteRuns');

    }

    public static function canViewDetailedInformationAboutRuns(Login $login) : bool
    {
        return static::canPermission($login, 'viewDetailedInformationAboutRuns');

    }

    public static function canjoinRuns(Login $login) : bool
    {
        return static::canPermission($login, 'joinRuns');
    }

}