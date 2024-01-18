<?php

/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Models\Login $login */
/** @var \App\Core\LinkGenerator $link */
$login = $data['login'];
?>
<script src="public/js/formCheckPassword.js" defer></script>
<div class="container-fluid">
        <div class="col">
            <h1>
               Nastavenia
            </h1>
        </div>
    <section class="h-100 bg-dark">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card card-registration my-4">
                        <div class="row g-0">
                            <div class="col-xl-6">
                                <form id="personalDetailForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("updatePersonalDetail") ?>">
                                    <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Úprava osobných údajov bežca</h3>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input value="<?= $login->getName() ?>" name="name" type="text" id="name" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="name">Meno</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input value="<?= $login->getSurname() ?>" name="surname" type="text" id="surname" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="surname">Priezvisko</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input value="<?= $login->getHtmlBirthDate() ?>" name="birthDate" type="date" id="birthDate" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="birthDate">Dátum narodenia</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input value="<?= $login->getStreet() ?>" name="street" type="text" id="street" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="street">Ulica</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input value="<?= $login->getCity() ?>" name="city" type="text" id="city" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="city">Mesto</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input value="<?= $login->getPostalCode() ?>" name="postalCode" type="text" pattern="\d{3}[ ]?\d{2}" id="postalCode" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="postalCode">PSČ</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end pt-3">
                                            <button name="submit" id="submitButton1" type="submit" class="btn btn-warning btn-lg ms-2">Upraviť</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-xl-6">
                                <form id="runnerForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("updateLogin") ?>">
                                    <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Úprava loginu</h3>
                                        <div class="row">
                                        <div class="form-outline mb-4">
                                            <input value="<?= $login->getLogin() ?>" name="email" type="email" id="email" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="email">Email</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input name="password" type="password" id="password" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="password">Nové heslo</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="passwordRepeat" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="passwordRepeat">Zopakujte nové heslo</label>
                                        </div>
                                        <span id="error" class="alert alert-danger" hidden></span>
                                        <div class="d-flex justify-content-end pt-3">
                                            <button name="submit" id="submitButton2" type="submit" class="btn btn-warning btn-lg ms-2">Upraviť</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="row g-0 d-flex justify-content-center">
                        <form id="deleteForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("unregister") ?>">
                            <button name="submit" id="submitButton3" type="submit" class="btn btn-danger btn-lg ms-2">Odstrániť účet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>