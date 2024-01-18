<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\FormChecker;
use App\Helpers\PermissionChecker;
use App\Models\Login;
use App\Models\PersonalDetail;
use App\Models\Runner;
use App\Models\UserRole;

class RunnerController extends AControllerBase
{

    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        return $this->app->getAuth()->isLogged();
    }

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        $login = Login::getOne($this->app->getAuth()->getLoggedUserId());
        if (is_null($login))
        {
            throw new HTTPException(403, "Unauthorized");
        }
        return $this->html(
            [
                'login' => $login
            ]
        );
    }

    public function updatePersonalDetail() : Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (FormChecker::checkUpdatePersonalDetailForm($formData))
        {
            FormChecker::sanitizeUpdatePersonalDetail($formData, $name, $surname, $birthDate, $street, $city, $postalCode);

            $login = Login::getOne($this->app->getAuth()->getLoggedUserId());
            $login->setName($name);
            $login->setSurname($surname);
            $login->setBirthDate($birthDate);
            $login->setStreet($street);
            $login->setCity($city);
            $login->setPostalCode($postalCode);
            $login->save();
        }
        else {
            throw new HTTPException(400, "Bad request");
        }
        return $this->redirect($this->url("runner.nastavenia"));
    }

    public function updateLogin() : Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (FormChecker::checkUpdateLoginForm($formData)) {
            FormChecker::sanitizeUpdateLogin($formData,  $email, $password,);
            $login = Login::getOne($this->app->getAuth()->getLoggedUserId());
            $login->setLogin($email);
            $login->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $login->save();
        }
        else {
            throw new HTTPException(400, "Bad request");
        }

        return $this->redirect($this->url("runner.nastavenia"));
    }

    public function unregister() : Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (FormChecker::checkSubmit($formData))
        {
            throw new HTTPException(400, "Bad request");
        }

        $login = Login::getOne($this->app->getAuth()->getLoggedUserId());

        if (!PermissionChecker::canDeleteAccount($login))
        {
            throw new HTTPException(403, "Forbidden");
        }

        UserRole::removeAllRolesFromUser($login);
        $login->delete();
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index"));
    }

    public function nastavenia() : Response
    {
        $login = Login::getOne($this->app->getAuth()->getLoggedUserId());

        return $this->html(
            [
                'login' => $login
            ]
        );
    }
}