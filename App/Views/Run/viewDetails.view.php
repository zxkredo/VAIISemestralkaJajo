<?php

/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Models\Run $run */
/** @var \App\Core\LinkGenerator $link */
$user = App\Models\Login::getOne($auth->getLoggedUserId());
$run = $data['run'];
$canCreateRuns = $auth->isLogged()
    && \App\Helpers\PermissionChecker::canCreateRuns($user)
    && ($run->getOrganiserId() == $auth->getLoggedUserId()
        || \App\Helpers\PermissionChecker::isAdmin($user));
?>
<div class="col-xl-6">
    <?php if ($canCreateRuns) : ?>
    <form id="runForm" class="row g-3 needs-validation" method="post" action="<?= $link->url('run.edit') ?>" enctype="multipart/form-data">
    <?php endif; ?>
        <div class="card-body p-md-5 text-black">
            <h3 class="mb-5 text-uppercase"><?= $canCreateRuns ? "Úprava " : "Informácie o "?>behu</h3>
            <?php if ($canCreateRuns) : ?>
            <input type="hidden" id="runId" name="id" value="<?=$run->getId()?>">
            <?php endif; ?>
            <div class="form-outline mb-4">
                <input value="<?=$run->getName()?>" name="name" type="text" id="name" class="form-control form-control-lg" required <?= $canCreateRuns ? "" : "readonly"?>/>
                <label class="form-label" for="name">Názov</label>
            </div>

            <div class="form-outline mb-4">
                <input value="<?=$run->getLocation()?>" name="location" type="text" id="location" class="form-control form-control-lg" required <?= $canCreateRuns ? "" : "readonly"?>/>
                <label class="form-label" for="location">Miesto konania</label>
            </div>

            <div class="form-outline mb-4">
                <textarea name="description" id="description" class="form-control form-control-lg" required <?= $canCreateRuns ? "" : "readonly"?>><?=$run->getDescription()?></textarea>
                <label class="form-label" for="description">Popis</label>
            </div>

            <div class="form-outline mb-4">
                <input value="<?=$run->getCapacity()?>" name="capacity" type="text" id="number" class="form-control form-control-lg" required <?= $canCreateRuns ? "" : "readonly"?>/>
                <label class="form-label" for="capacity">Kapacita</label>
            </div>

            <div class="form-outline mb-4">
                <input value="<?=$run->getPriceInCents()?>" name="price_in_cents" type="number" id="price_in_cents" class="form-control form-control-lg" required <?= $canCreateRuns ? "" : "readonly"?>/>
                <label class="form-label" for="price_in_cents">Cena v centoch</label>
            </div>

            <?php if ($canCreateRuns) : ?>
            <div class="form-outline mb-4">
                <input value="" name="picture" type="file" id="picture" class="form-control form-control-lg"/>
                <label class="form-label" for="picture">Obrázok</label>
            </div>
            <div class="d-flex justify-content-end pt-3">
                <button name="submit" id="submitButton2" type="submit" class="btn btn-warning btn-lg ms-2">Upraviť</button>
            </div>
            <?php else: ?>
            <div class="form-outline mb-4">
                <img src="<?=\App\Helpers\FileStorage::UPLOAD_DIR . '/' .$run->getPictureName()?>" class="card-img-top" alt="picture">
            </div>
            <?php endif; ?>
    <?php if ($canCreateRuns) : ?>
    </form>
    <?php endif; ?>
</div>