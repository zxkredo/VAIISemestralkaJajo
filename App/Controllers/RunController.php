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
use App\Models\RunParticipant;

class RunController extends AControllerBase
{
    public function authorize(string $action) : bool
    {
        switch ($action)
        {
            case 'index':
            case 'view':
                return $this->app->getAuth()->isLogged();
            case 'create':
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
     * @throws \Exception
     */
    public function index(): Response
    {
        //Shows all available runs, for organisers a button to add a run
        return $this->html([
            'runs' => Run::getAll()
        ]);
    }

    public function create(): Response
    {
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
            $newRun->setOrganiserId($this->app->getAuth()->getLoggedUserId());
            $newRun->setName($name);
            $newRun->setLocation($location);
            $newRun->setDescription($description);
            $newRun->setCapacity($capacity);
            $newRun->setPriceInCents($price_in_cents);
            $newRun->setPictureName(FileStorage::saveFile($this->request()->getFiles()['picture']));
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
        if (!FormChecker::checkRunId($formData))
        {
            throw new HTTPException(400, "Bad request");
        }

        if (!self::tryGetRun($formData, $run)) {
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

    /**
     * @throws HTTPException
     * @throws \Exception
     */
    public function delete(): Response
    {
        $formData = $this->app->getRequest()->getPost();

        if (!PermissionChecker::canDeleteRuns(Login::getOne($this->app->getAuth()->getLoggedUserId()))) {
            throw new HTTPException(403, 'Unauthorized');
        }

        if (!FormChecker::checkSubmit($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!FormChecker::checkRunId($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!self::tryGetRun($formData, $run)) {
            throw new HTTPException(400, "Bad request");
        }
        $run->delete();

        return $this->redirect($this->url("run.index"));
    }

    /**
     * @throws HTTPException
     */
    public function view() : Response
    {
        //shows public information about a run

        $formData = $this->app->getRequest()->getPost();

        if (!FormChecker::checkSubmit($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!FormChecker::checkRunId($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!self::tryGetRun($formData, $run)) {
            throw new HTTPException(400, "Bad request");
        }

        return $this->html([
            'run' => $run
        ]);
    }

    /**
     * @throws HTTPException
     */
    public function viewDetails(): Response
    {
        //shows more specific details about a run, organisers will have an option to update them
        $formData = $this->app->getRequest()->getPost();

        if (!FormChecker::checkSubmit($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!FormChecker::checkRunId($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!self::tryGetRun($formData, $run)) {
            throw new HTTPException(400, "Bad request");
        }

        return $this->html([
            'run' => $run
        ]);
    }

    /**
     * @throws HTTPException
     * @throws \Exception
     */
    public function join(): Response
    {
        $formData = $this->app->getRequest()->getPost();

        if (!FormChecker::checkSubmit($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!FormChecker::checkRunId($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!self::tryGetRun($formData, $run)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!RunParticipant::tryJoinRun(Login::getOne($this->app->getAuth()->getLoggedUserId()),$run))
        {
            throw new HTTPException(400, "Bad request, already joined run");
        }

        return $this->redirect($this->url("run.index"));
    }

    /**
     * @throws HTTPException
     * @throws \Exception
     */
    public function leave(): Response
    {
        $formData = $this->app->getRequest()->getPost();

        if (!FormChecker::checkSubmit($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!FormChecker::checkRunId($formData)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!self::tryGetRun($formData, $run)) {
            throw new HTTPException(400, "Bad request");
        }

        if (!RunParticipant::tryLeaveRun(Login::getOne($this->app->getAuth()->getLoggedUserId()),$run))
        {
            throw new HTTPException(400, "Bad request, cannot leave run in which not participating");
        }

        return $this->redirect($this->url("run.index"));
    }

    private static function tryGetRun(array $formData, ?Run &$run) : bool
    {
        $runId = $formData['id'];
        try {
            $run = Run::getOne($runId);
        }
        catch (\Exception $e)
        {
            return false;
        }

        return true;
    }
}