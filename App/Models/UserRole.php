<?php

namespace App\Models;

use App\Core\Model;
use http\Client\Curl\User;

class UserRole extends Model
{
    protected null|int $id = null;
    protected int $role_id;
    protected int $login_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function getLoginId(): int
    {
        return $this->login_id;
    }

    public function setLoginId(int $login_id): void
    {
        $this->login_id = $login_id;
    }

    /**
     * If user already has the role, function returns false
     * @param Login $login
     * @param Role $role
     * @return bool True if role has been added without complications
     * @throws \Exception
     */
    public static function trySetRoleToUser(Login $login, Role $role): bool {
        if (static::hasRole($login, $role))
        {
            return false;
        }

        $newUserRole = new UserRole();
        $newUserRole->role_id = $role->getId();
        $newUserRole->login_id = $login->getId();
        $newUserRole->save();

        return true;
    }

    /**
     * Tries to remove role from user.
     * Returns false if the user doesn't have the provided role
     * @param Login $login
     * @return bool True if role was successfully removed
     */
    public static function tryRemoveRoleFromUser(Login $login, Role $role) : bool
    {
        $userUserRoles = static::getAll('login_id=?', [$login->getId()]);
        foreach ($userUserRoles as $userUserRole)
        {
            if ($userUserRole->role_id == $role->getId())
            {
                $userUserRole->delete();
                return true;
            }
        }
        return false;
    }

    /**
     * Returns all roles of user
     * @param Login $login
     * @return Role[]
     * @throws \Exception
     */
    public static function getAllRolesOfUser(Login $login) : array
    {
        $userUserRoles = static::getAll('login_id=?', [$login->getId()]);
        $userRolesOutput = array();
        foreach ($userUserRoles as $userUserRole)
        {
            $userRolesOutput[] = Role::getOne($userUserRole->getRoleId());
        }
        return $userRolesOutput;
    }

    /**
     * Removes all connections between roles and the user
     * @param Login $login
     * @return void
     * @throws \Exception
     */
    public static function removeAllRolesFromUser(Login $login): void
    {
        $userUserRoles = static::getAll('login_id=?', [$login->getId()]);
        foreach ($userUserRoles as $userUserRole)
        {
            $userUserRole->delete();
        }
    }

    /**
     * Returns true if user has the role
     * @param Login $login
     * @param Role $role
     * @return bool
     * @throws \Exception
     */
    public static function hasRole(Login $login, Role $role) : bool
    {
        $userRoles = static::getAllRolesOfUser($login);
        foreach ($userRoles as $userRole)
        {
            if ($userRole->getId() == $role->getId())
            {
                return true;
            }
        }
        return false;
    }
}