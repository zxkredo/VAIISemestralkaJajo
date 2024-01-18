<?php

namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    protected null|int $id = null;
    protected string $name;
    protected ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public static function getRoleByName(string $name) : ?Role {
        //name is unique so should never return more than 1
        $roles = self::getAll('name=\'?\'', [$name]);
        if (empty($runners))
        {
            return null;
        }
        else
        {
            return $runners[0];
        }
    }
}