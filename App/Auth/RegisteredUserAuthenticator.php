<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Models\Login;

class RegisteredUserAuthenticator implements IAuthenticator
{


    public function __construct()
    {
        session_start();
    }

    /**
     * Verify, if the user is in DB and has his password is correct
     * @param $login
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public function login($login, $password): bool
    {
        $loggedUser = Login::getByLogin($login);
        if (is_null($loggedUser))
        {
            return false;
        }
        else if (password_verify($password, $loggedUser->getPassword())) {
            $_SESSION['userId'] = $loggedUser->getId();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Logout the user
     */
    public function logout(): void
    {
        if (isset($_SESSION["userId"])) {
            unset($_SESSION["userId"]);
            session_destroy();
        }
    }

    /**
     * Get the name of the logged-in user
     * @return string
     * @throws \Exception
     */
    public function getLoggedUserName(): string
    {
        $loggedUser = Login::getOne($_SESSION['userId']);
        return !is_null($loggedUser) ? $loggedUser->getLogin() : throw new \Exception("User not registered");
    }

    /**
     * Get the context of the logged-in user
     * @return string
     */
    public function getLoggedUserContext(): mixed
    {
        return null;
    }

    /**
     * Return if the user is authenticated or not
     * @return bool
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['userId']) && $_SESSION['userId'] != null;
    }

    public function getLoggedUserId(): mixed
    {
        return $_SESSION['userId'] ?? throw new \Exception("User not logged in");
    }
}