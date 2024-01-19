<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\PermissionChecker;
use App\Models\Login;

class RunController extends AControllerBase
{
    public function authorize(string $action) : bool
    {
        switch ($action)
        {
            case 'index':
                return $this->app->getAuth()->isLogged();
            case 'add':
            case 'edit':
                return $this->app->getAuth()->isLogged()
                    && PermissionChecker::canCreateRuns(Login::getOne($this->app->getAuth()->getLoggedUserId()));
            case 'delete':
                return $this->app->getAuth()->isLogged()
                    && PermissionChecker::canDeleteRuns(Login::getOne($this->app->getAuth()->getLoggedUserId()));
            case 'viewDetails':
                return $this->app->getAuth()->isLogged()
                    && PermissionChecker::canViewDetailedInformationAboutRuns(Login::getOne($this->app->getAuth()->getLoggedUserId()));
            case 'join':
            case 'leave':
                return $this->app->getAuth()->isLogged()
                    && PermissionChecker::canjoinRuns(Login::getOne($this->app->getAuth()->getLoggedUserId()));
            default:
                return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html();
    }

    public function add(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }
    public function edit(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }
    public function delete(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }
    public function viewDetails(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }
    public function join(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }
    public function leave(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }

}