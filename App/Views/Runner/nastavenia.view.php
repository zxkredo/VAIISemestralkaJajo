<?php

/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Models\PersonalDetail $personalDetail */
/** @var \App\Core\LinkGenerator $link */
$personalDetail = $data['personalDetail'];
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
                                                    <input name="name" type="text" id="name" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="name">Meno</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input name="surname" type="text" id="surname" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="surname">Priezvisko</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                                            <h6 class="mb-0 me-4">Pohlavie: </h6>

                                            <div class="form-check form-check-inline mb-0 me-4">
                                                <input name="gender" class="form-check-input" type="radio" id="femaleGender"
                                                       value="female" required/>
                                                <label class="form-check-label" for="femaleGender">Žena</label>
                                            </div>

                                            <div class="form-check form-check-inline mb-0 me-4">
                                                <input name="gender" class="form-check-input" type="radio" id="maleGender"
                                                       value="male" required/>
                                                <label class="form-check-label" for="maleGender">Muž</label>
                                            </div>

                                            <div class="form-check form-check-inline mb-0">
                                                <input name="gender" class="form-check-input" type="radio" id="otherGender"
                                                       value="other" required/>
                                                <label class="form-check-label" for="otherGender">Iné</label>
                                            </div>

                                        </div>

                                        <div class="form-outline mb-4">
                                            <input name="birthDate" type="date" id="birthDate" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="birthDate">Dátum narodenia</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input name="street" type="text" id="street" class="form-control form-control-lg" required/>
                                            <label class="form-label" for="street">Ulica</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input name="city" type="text" id="city" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="city">Mesto</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input name="postalCode" type="text" pattern="\d{3}[ ]?\d{2}" id="postalCode" class="form-control form-control-lg" required/>
                                                    <label class="form-label" for="postalCode">PSČ</label>
                                                </div>
                                            </div>
                                        </div>

                                        <span id="error" class="alert alert-danger" hidden></span>
                                        <div class="d-flex justify-content-end pt-3">
                                            <button name="submit" id="submitButton" type="submit" class="btn btn-warning btn-lg ms-2">Upraviť</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-xl-6">
                                <form id="loginForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("updateLogin") ?>">
                                    <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Úprava loginu</h3>
                                        <div class="row">
                                        <div class="form-outline mb-4">
                                            <input name="email" type="email" id="email" class="form-control form-control-lg" required/>
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
                                            <button name="submit" id="submitButton" type="submit" class="btn btn-warning btn-lg ms-2">Upraviť</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="row g-0 d-flex justify-content-center">
                        <form id="runnerForm" class="row g-3 needs-validation" method="post" action="<?= $link->url("unregister") ?>">
                            <button name="submit" id="submitButton" type="submit" class="btn btn-danger btn-lg ms-2">Odstrániť účet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>