<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Models\Login;
use App\Models\PersonalDetail;
use App\Models\Runner;

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
        $loggedRunner= Runner::getByLoginId($this->app->getAuth()->getLoggedUserId());
        if (is_null($loggedRunner))
        {
            throw new HTTPException(403, "Unauthorized");
        }
        $personalDetail = PersonalDetail::getOne($loggedRunner->getPersonalDetailsId());
        return $this->html(
            [
                'personalDetail' => $personalDetail
            ]
        );
    }

    public function updatePersonalDetail() : Response
    {
        throw new HTTPException(500, "Not implemented");
    }

    public function updateLogin() : Response
    {
        throw new HTTPException(500, "Not implemented");
    }

    public function unregister() : Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (!isset($formData['submit']))
        {
            throw new HTTPException(400, "Bad request");
        }

        $runner = Runner::getByLoginId($this->app->getAuth()->getLoggedUserId());
        $runner->unregister();
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index"));
    }

    public function nastavenia() : Response
    {
        $loggedRunner= Runner::getByLoginId($this->app->getAuth()->getLoggedUserId());
        if (is_null($loggedRunner))
        {
            throw new HTTPException(403, "Unauthorized");
        }
        $personalDetail = PersonalDetail::getOne($loggedRunner->getPersonalDetailsId());
        return $this->html(
            [
                'personalDetail' => $personalDetail
            ]
        );
    }
}