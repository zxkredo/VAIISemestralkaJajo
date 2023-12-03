<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;

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
        return $this->html();
    }

    public function updatePersonalDetail() : Response
    {
        throw new HTTPException(500, "Not implemented");
    }

    public function updateLogin() : Response
    {
        throw new HTTPException(500, "Not implemented");
    }
}