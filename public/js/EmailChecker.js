import {EmailAPI} from "./EmailAPI.js";

/**
 * Main chat class
 */
class EmailChecker {
    /**
     * API for checking email
     * @type {EmailAPI}
     */
    #emailService

    #emailElementId;
    #submitElementId;
    #errorElementId


    constructor(emailElementId, submitElementId, errorElementId) {

        this.#emailService = new EmailAPI();
        this.#emailElementId = emailElementId;
        this.#submitElementId = submitElementId;
        this.#errorElementId = errorElementId;
        // Periodically ask API for new messages and status
        setInterval(
            () => this.checkChanges(),
            500
        );

    }

    async checkChanges() {
        let response = await this.#emailService.checkEmailAvailability(document.getElementById(this.#emailElementId).value);
        if (response === false)
        {
            document.getElementById(this.#errorElementId).hidden = false;
        }
        else
        {
            document.getElementById(this.#errorElementId).hidden = true;
        }
    }
}

export {EmailChecker}