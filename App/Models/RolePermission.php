<?php

namespace App\Models;

use App\Core\Model;

class RolePermission extends Model
{
    protected null|int $id = null;
    protected int $role_id;
    protected int $permission_id;

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

    public function getPermissionId(): int
    {
        return $this->permission_id;
    }

    public function setPermissionId(int $permission_id): void
    {
        $this->permission_id = $permission_id;
    }
}