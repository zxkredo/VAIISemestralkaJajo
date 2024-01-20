<?php

/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Models\Run $run */
/** @var \App\Core\LinkGenerator $link */
$canCreateRuns = $auth->isLogged() && \App\Helpers\PermissionChecker::canjoinRuns(App\Models\Login::getOne($auth->getLoggedUserId()));
$run = $data['run']
?>
<div class="col-xl-6">
        <div class="card-body p-md-5 text-black">
            <h3 class="mb-5 text-uppercase">Informácie o behu: <?=$run->getName()?></h3>

            <div class="form-outline mb-4">
                <h5> Miesto konania:</h5>
                <p><?=$run->getLocation()?></p>
            </div>

            <div class="form-outline mb-4">
                <h5>Popis:</h5>
                <p><?=$run->getDescription()?></p>
            </div>

            <div class="form-outline mb-4">
                <h5>Kapacita:</h5>
                <p><?=$run->getCapacity()?></p>
            </div>

            <div class="form-outline mb-4">
                <h5>Cena:</h5>
                <p><?=$run->getPriceInCents() / 100?>€</p>
            </div>

            <div class="form-outline mb-4">
                <img src="<?=\App\Helpers\FileStorage::UPLOAD_DIR . '/' .$run->getPictureName()?>" class="card-img-top" alt="picture">
            </div>

</div>