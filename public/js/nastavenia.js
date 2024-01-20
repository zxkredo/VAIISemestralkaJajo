import {EmailChecker} from "./EmailChecker.js";

function checkForm() {
    const password = document.getElementById("password");
    const passwordRepeat = document.getElementById("passwordRepeat");
    const error = document.getElementById('error');
    const emailError = document.getElementById('emailError');

    if (password.value !== passwordRepeat.value) {
        error.hidden = false;
        error.innerText = "Heslá sa nezhodujú!";
        return false;
    } else if (!emailError.hidden) {
        return false;
    } else {
        error.hidden = true;
        error.innerText = "";
    }
}


document.emailChecker = new EmailChecker('email', 'submitButton2', 'emailError');
document.getElementById('runnerForm').onsubmit = checkForm;


