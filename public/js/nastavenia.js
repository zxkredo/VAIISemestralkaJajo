import {EmailChecker} from "./EmailChecker.js";

document.emailChecker = new EmailChecker('email', 'submitButton2', 'emailError');
document.getElementById('runnerForm').onsubmit = sendLoginDetailForm;

document.getElementById('personalDetailForm').onsubmit = sendPersonalDetailForm;

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
        return true;
    }
}


function sendLoginDetailForm() {
    if (checkForm()) {
        // Get form data
        const formData = new FormData(document.getElementById('runnerForm'));
        formData.append('submit', '');
        let apiEndPoint = document.getElementById('runnerForm').action;
        disableUserInteractions();
        // Make a POST request using Fetch API
        fetch(apiEndPoint, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Nastala chyba na strane servera ${response.status} ${response.statusText}`);
                }
                // Return the response as text
                return response.text();
            })
            .then(data => {
                // Handling the response data is not necessary as it only returns values that are already in inputs
                alert('Úspešne ste si zmenili osobné údaje');
            })
            .catch(error => {
                // Handle errors
                console.error('Error:', error);
                alert('Nastala chyba pri spracovaní dát zo servera');
            })
            .finally(() => {
                // Enable user interactions after the promise is handled
                document.getElementById('password').value = "";
                document.getElementById("passwordRepeat").value = "";
                enableUserInteractions();
            });
    }

    return false;
}

function sendPersonalDetailForm() {
    // Get form data
    const formData = new FormData(document.getElementById('personalDetailForm'));
    formData.append('submit', '');
    let apiEndPoint = document.getElementById('personalDetailForm').action;
    disableUserInteractions();
    // Make a POST request using Fetch API
    fetch(apiEndPoint, {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Nastala chyba na strane servera ${response.status} ${response.statusText}`);
            }
            // Return the response as text
            return response.text();
        })
        .then(data => {
            // Handling the response data is not necessary as it only returns values that are already in inputs
            alert('Úspešne ste si zmenili prihlasovanie údaje');
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
            alert('Nastala chyba pri spracovaní dát zo servera');
        })
        .finally(() => {
            // Enable user interactions after the promise is handled
            enableUserInteractions();
        });
    return false;
}

function disableUserInteractions() {
    // Disable buttons and inputs in all forms
    const forms = document.getElementsByTagName('form');
    for (let i = 0; i < forms.length; i++) {
        const form = forms[i];

        // Disable text input fields
        const textInputs = form.getElementsByTagName('input');
        for (let j = 0; j < textInputs.length; j++) {
            textInputs[j].disabled = true;
        }

        // Disable buttons
        const buttons = form.getElementsByTagName('button');
        for (let j = 0; j < buttons.length; j++) {
            buttons[j].disabled = true;
        }
    }
}

function enableUserInteractions() {
    // Enable buttons and inputs in all forms
    const forms = document.getElementsByTagName('form');
    for (let i = 0; i < forms.length; i++) {
        const form = forms[i];

        // Disable text input fields
        const textInputs = form.getElementsByTagName('input');
        for (let j = 0; j < textInputs.length; j++) {
            textInputs[j].disabled = false;
        }

        // Disable buttons
        const buttons = form.getElementsByTagName('button');
        for (let j = 0; j < buttons.length; j++) {
            buttons[j].disabled = false;
        }
    }
}