<?php

namespace App\Models;

use App\Core\Model;

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

}