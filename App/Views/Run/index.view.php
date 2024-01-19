<?php
/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var Array $runs */
/** @var \App\Models\Login $login */
/** @var \App\Models\Run $run */
/** @var \App\Core\LinkGenerator $link */

$runs = $data['runs']
?>

<?php foreach($runs as $run): ?>
    <div class="card" style="width: 18rem;">
        <img src="<?=\App\Helpers\FileStorage::UPLOAD_DIR . '/' .$run->getPictureName()?>" class="card-img-top" alt="picture">
        <div class="card-body">
            <h5 class="card-title"><?=$run->getName()?></h5>
            <p class="card-text"><?=$run->getDescription()?></p>
            <?php if ($auth->isLogged() && \App\Helpers\PermissionChecker::canjoinRuns(App\Models\Login::getOne($auth->getLoggedUserId()))) : ?>
                <?php if (\App\Models\RunParticipant::participatesInRun(App\Models\Login::getOne($auth->getLoggedUserId()), $run)) : ?>
                    <form id="leaveForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("leave") ?>">
                        <input type="hidden" id="runId" name="id" value="<?=$run->getId()?>">
                        <button name="submit" id="submitButtonLeave" type="submit" class="btn btn-danger">Odhlásiť sa</button>
                    </form>
                <?php else: ?>
                    <form id="joinForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("join") ?>">
                        <input type="hidden" id="runId" name="id" value="<?=$run->getId()?>">
                        <button name="submit" id="submitButtonJoin" type="submit" class="btn btn-primary">Prihlásiť sa</button>
                    </form>
                <?php endif;?>
            <?php endif;?>
            <?php if ($auth->isLogged() && \App\Helpers\PermissionChecker::canViewDetailedInformationAboutRuns(App\Models\Login::getOne($auth->getLoggedUserId()))) : ?>
                <form id="viewDetailsForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("viewDetails") ?>">
                    <input type="hidden" id="runId" name="id" value="<?=$run->getId()?>">
                    <button name="submit" id="submitButtonViewDetails" type="submit" class="btn btn-primary">Upraviť</button>
                </form>
            <?php else: ?>
                <form id="viewForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("view") ?>">
                    <input type="hidden" id="runId" name="id" value="<?=$run->getId()?>">
                    <button name="submit" id="submitButtonView" type="submit" class="btn btn-primary">Zobraziť detaily</button>
                </form>
            <?php endif;?>
        </div>
    </div>
<?php endforeach; ?>

<?php if ($auth->isLogged() && \App\Helpers\PermissionChecker::canCreateRuns(App\Models\Login::getOne($auth->getLoggedUserId()))) : ?>
    <a href="<?= $link->url("create")?>" class="btn btn-primary">Vytvoriť nový beh</a>
<?php endif ?>