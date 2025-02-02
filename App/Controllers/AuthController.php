<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\HTTPException;
use App\Core\LinkGenerator;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Helpers\FormChecker;
use App\Models\Login;
use App\Models\Role;
use App\Models\UserRole;
use DateTime;
use Exception;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    /**
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    public function registracia() : Response
    {
        return $this->html();
    }

    /**
     * Login a user
     * @return Response
     */
    public function login(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        $logged = null;
        if (isset($formData['submit'])) {
            $logged = $this->app->getAuth()->login($formData['login'], $formData['password']);
            if ($logged) {
                return $this->redirect($this->url("runner.index"));
            }
        }

        $data = ($logged === false ? ['message' => 'Zlý login alebo heslo!'] : []);
        return $this->html($data);
    }

    /**
     * Logout a user
     * @return ViewResponse
     */
    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index"));
    }

    /**
     * @throws HTTPException
     */
    public function register() : Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (FormChecker::checkAllPersonalDetailForm($formData)) {
            FormChecker::sanitizeAllNastaveniaForm($formData, $name, $surname, $gender, $birthDate, $street, $city, $postalCode, $email, $password);
            if (!is_null(Login::getByLogin($email)))
            {
                throw new HTTPException(400, "Bad request, email already in use");
            }
            $newLogin = new Login();
            $newLogin->setLogin($email);
            $newLogin->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $newLogin->setName($name);
            $newLogin->setSurname($surname);
            $newLogin->setGender($gender);
            $newLogin->setBirthDate($birthDate);
            $newLogin->setStreet($street);
            $newLogin->setCity($city);
            $newLogin->setPostalCode($postalCode);
            $newLogin->save();

            if (!UserRole::trySetRoleToUser($newLogin, Role::getRoleByName('runner')))
            {
                $newLogin->delete();
                throw new HTTPException(500, "Internal server error, account not created.");
            };
        }
        else {
            throw new HTTPException(400, "Bad request");
        }
        return $this->redirect($this->url("auth.login"));
    }
}

