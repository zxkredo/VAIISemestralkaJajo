<?php

namespace App\Models;

use App\Core\Model;

class RunParticipant extends Model
{
    protected null|int $id = null;
    protected int $run_id;
    protected int $login_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getRunId(): int
    {
        return $this->run_id;
    }

    public function setRunId(int $run_id): void
    {
        $this->run_id = $run_id;
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
     * Returns all runs which user participates in
     * @param Login $login
     * @return Run[]
     * @throws \Exception
     */
    public static function getAllRunsOfUser(Login $login) : array
    {
        $runParticipantRuns = static::getAll('login_id=?', [$login->getId()]);
        $runsOutput = array();
        foreach ($runParticipantRuns as $runParticipantRun)
        {
            $runsOutput[] = Run::getOne($runParticipantRun->getRunId());
        }
        return $runsOutput;
    }


    /**
     * If user already has joined run, function returns false
     * @param Login $login
     * @param Run $run
     * @return bool True if connection between a runner and a run has been created without complications
     * @throws \Exception
     */
    public static function tryJoinRun(Login $login, Run $run): bool {
        if (static::participatesInRun($login, $run))
        {
            return false;
        }

        $newRunParticipant = new RunParticipant();
        $newRunParticipant->setRunId($run->getId());
        $newRunParticipant->setLoginId($login->getId());
        $newRunParticipant->save();

        return true;
    }

    /**
     * Tries to remove runner from run.
     * Returns false if the user isn't participating in run
     * @param Login $login
     * @param Run $run
     * @return bool True if runner was successfully removed from run
     * @throws \Exception
     */
    public static function tryLeaveRun(Login $login, Run $run) : bool
    {
        $runParticipantRuns = static::getAll('login_id=?', [$login->getId()]);
        foreach ($runParticipantRuns as $runParticipantRun)
        {
            if ($runParticipantRun->getRunId() == $run->getId())
            {
                $runParticipantRun->delete();
                return true;
            }
        }
        return false;
    }

    /**
     * Returns true if user participates in run
     * @param Login $login
     * @param Run $run
     * @return bool
     * @throws \Exception
     */
    public static function participatesInRun(Login $login, Run $run) : bool
    {
        $userRuns = static::getAllRunsOfUser($login);
        foreach ($userRuns as $userRun)
        {
            if ($userRun->getId() == $run->getId())
            {
                return true;
            }
        }
        return false;
    }
}