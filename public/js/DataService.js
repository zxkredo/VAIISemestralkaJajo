/**
 * Class contains methods for calling web API
 * source: https://github.com/thevajko/cv-10/blob/solution/public/js/chat/DataService.js
 */
class DataService {

    /**
     * Base url of the web API
     * @type {string}
     */
    #url = "http://localhost"
    /**
     * Prefix of target controller
     * @type {string}
     */
    #controller;

    constructor(controler) {
        this.#controller = controler;
    }

    /**
     * Build up URL for an action
     * @param {string} action
     * @returns {string} URL
     */
    baseUrl(action){
        return this.#url + "?c=" + this.#controller + "&a=" + action;
    }

    /**
     * Send a request to an endpoint (action)
     * @param {string} action Action in service controller
     * @param {string} method HTTP method (POST, GET etc.)
     * @param {number|string} responseCode Expected HTTP response code
     * @param {object} body  Parameters to be sent to the action
     * @param onErrorReturn If there will be an error in request processing, return this value
     * @returns {Promise<any|any>} Return Promise, because this method uses fetch method
     */
    async sendRequest(action, method, responseCode, body, onErrorReturn = null) {
        // Use exceptions to wrap the fetch call
        try {
            // Build up fetch and wait for response
            let response = await fetch(
                this.baseUrl(action), // URL to the action
                {
                    method: method,
                    body: JSON.stringify(body),
                    headers: { // Set headers for JSON communication
                        "Content-type": "application/json", // Send JSON
                        "Accept" : "application/json", // Accept only JSON as response
                    }
                });
            // If return code do not match our expected value throw error
            if (response.status !== responseCode ) return onErrorReturn;

            // If the response is empty (HTTP 204 No content), it's ok
            if (response.status === 204) return true;

            // Everything is ok, send the response
            return await response.json();
        } catch(ex) {
            // On any error just return error
            return onErrorReturn;
        }
    }
}

export {DataService}