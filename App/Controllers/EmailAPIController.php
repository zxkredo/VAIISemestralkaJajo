<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\FormChecker;
use App\Models\Login;

class EmailAPIController extends AControllerBase
{

    /**
     * Always returns 501 Not Implemented, API do not need index action
     * @throws HTTPException
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not Implemented");
    }

    public function checkEmailAvailability(): Response
    {
        $email = $this->request()->getValue('email');
        FormChecker::sanitizeEmail($email);
        if (is_null(Login::getByLogin($email)) ||
            ($this->app->getAuth()->isLogged() && $this->app->getAuth()->getLoggedUserName() == $email))
        {
            return $this->json(true);
        }
        else
        {
            return $this->json(false);
        }
    }
}