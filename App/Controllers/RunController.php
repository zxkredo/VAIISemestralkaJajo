<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Helpers\FormChecker;
use App\Helpers\PermissionChecker;
use App\Models\Login;
use App\Models\Run;

class RunController extends AControllerBase
{
    public function authorize(string $action) : bool
    {
        switch ($action)
        {
            case 'index':
            case 'view':
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
        //Shows all available runs, for organisers a button to add a run
        return $this->html();
    }

    /**
     * @throws HTTPException
     * @throws \Exception
     */
    public function add(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (FormChecker::checkAllRunForm($formData, $this->request()->getFiles())) {
            FormChecker::sanitizeAllRunForm($formData, $this->request()->getFiles(),$name, $location, $description, $capacity, $price_in_cents, $picture_name);
            $newRun = new Run();
            $newRun->setName($name);
            $newRun->setLocation($location);
            $newRun->setDescription($description);
            $newRun->setCapacity($capacity);
            $newRun->setPriceInCents($price_in_cents);

            FileStorage::saveFile($this->request()->getFiles()['picture']);
            $newRun->setPictureName($picture_name);
            $newRun->save();
        }
        else {
            throw new HTTPException(400, "Bad request");
        }
        return $this->redirect($this->url("run.index"));
    }

    /**
     * @throws HTTPException
     */
    public function edit(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (!isset($formData['id']) || is_null($formData['id']))
        {
            throw new HTTPException(400, "Bad request");
        }
        $runId = $formData['id'];

        $run = null;
        try {
            $run = Run::getOne($runId);
        }
        catch (\Exception $e)
        {
            throw new HTTPException(400, "Bad request");
        }

        //only the organiser who created the run can edit / or admin
        if ($run->getOrganiserId() != $this->app->getAuth()->getLoggedUserId() || PermissionChecker::isAdmin($this->app->getAuth()->getLoggedUserId()))
        {
            throw new HTTPException(403, "Unauthorized");
        }

        if (FormChecker::checkAllRunUpdateForm($formData)) {
            FormChecker::sanitizeAllRunUpdateForm($formData, $this->request()->getFiles(), $name, $location, $description, $capacity, $price_in_cents, $picture_name);
            $run->setName($name);
            $run->setLocation($location);
            $run->setDescription($description);
            $run->setCapacity($capacity);
            $run->setPriceInCents($price_in_cents);
            if ($picture_name != "")
            {
                FileStorage::deleteFile($run->getPictureName());
                FileStorage::saveFile($this->request()->getFiles()['picture']);
                $run->setPictureName($picture_name);
            }
            $run->save();
        }
        else {
            throw new HTTPException(400, "Bad request");
        }
        return $this->redirect($this->url("run.view"));
    }
    public function delete(): Response
    {
        throw new HTTPException(500, 'Not implemented.');
    }
    public function view() :Response
    {
        //shows public information about a run
        throw new HTTPException(500, 'Not implemented.');
    }
    public function viewDetails(): Response
    {
        //shows more specific details about a run, organisers will have an option to update them
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