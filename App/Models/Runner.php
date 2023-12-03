<?php

namespace App\Models;

use App\Core\Model;

class Runner extends Model
{
    protected null|int $id = null;
    protected int $logins_id;
    protected int $personalDetails_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLoginsId(): int
    {
        return $this->logins_id;
    }

    public function setLoginsId(int $logins_id): void
    {
        $this->logins_id = $logins_id;
    }

    public function getPersonalDetailsId(): int
    {
        return $this->personalDetails_id;
    }

    public function setPersonalDetailsId(int $personalDetails_id): void
    {
        $this->personalDetails_id = $personalDetails_id;
    }
    public static function getByLoginId(int $logins_id) : ?Runner
    {
        //$logins_id is FK, should never return more than 1
        $runners = self::getAll('logins_id=?', [$logins_id]);
        if (empty($runners))
        {
            return null;
        }
        else
        {
            return $runners[0];
        }
    }

    public function unregister() : void
    {
        $personalDetail = PersonalDetail::getOne($this->personalDetails_id);
        $login = Login::getOne($this->logins_id);
        $this->delete();
        $personalDetail->delete();
        $login->delete();
    }
}