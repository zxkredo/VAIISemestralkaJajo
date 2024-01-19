<?php

/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Models\Login $login */
/** @var \App\Core\LinkGenerator $link */
?>
<div class="col-xl-6">
    <form id="runForm" class="row g-3 needs-validation" method="post" action="<?= $link->url('run.add') ?>">
        <div class="card-body p-md-5 text-black">
            <h3 class="mb-5 text-uppercase">Pridanie behu</h3>
            <div class="form-outline mb-4">
                <input value="" name="name" type="text" id="name" class="form-control form-control-lg" required/>
                <label class="form-label" for="name">Názov</label>
            </div>

            <div class="form-outline mb-4">
                <input value="" name="location" type="text" id="location" class="form-control form-control-lg" required/>
                <label class="form-label" for="location">Miesto konania</label>
            </div>

            <div class="form-outline mb-4">
                <textarea name="description" id="description" class="form-control form-control-lg" required></textarea>
                <label class="form-label" for="description">Popis</label>
            </div>

            <div class="form-outline mb-4">
                <input value="" name="capacity" type="text" id="capacity" class="form-control form-control-lg" required/>
                <label class="form-label" for="capacity">Kapacita</label>
            </div>

            <div class="form-outline mb-4">
                <input value="" name="price_in_cents" type="text" id="price_in_cents" class="form-control form-control-lg" required/>
                <label class="form-label" for="price_in_cents">Cena v centoch</label>
            </div>

            <div class="form-outline mb-4">
                <input value="" name="picture" type="file" id="picture" class="form-control form-control-lg" required/>
                <label class="form-label" for="picture">Obrázok</label>
            </div>

            <div class="d-flex justify-content-end pt-3">
                <button name="submit" id="submitButton2" type="submit" class="btn btn-warning btn-lg ms-2">Pridať</button>
            </div>
    </form>
</div>