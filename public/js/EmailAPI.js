import {DataService} from "./DataService.js";

class EmailAPI extends DataService {

    constructor() {
        super("EmailAPI");
    }

    async checkEmailAvailability(email = null) {
        let emailToSend = email == null ? "" : "&email=" + email;
        return await this.sendRequest(
            "checkEmailAvailability" + emailToSend,
            "POST",
            200,
            null,
            false);
    }

}

export {EmailAPI}