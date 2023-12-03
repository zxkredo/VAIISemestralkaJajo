<?php

/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Models\PersonalDetail $personalDetail */
/** @var \App\Core\LinkGenerator $link */
$personalDetail = $data['personalDetail'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="d-flex justify-content-center">
            <h1>
                Vitaj, <strong><?= $personalDetail->getName() ?> <?= $personalDetail->getSurname() ?></strong>!<br><br>
            </h1>
        </div>
        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-secondary" href="<?= $link->url("runner.nastavenia")?>">Nastavenia</a>
        </div>
    </div>
</div>