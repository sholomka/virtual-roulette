import { ajax } from "Classes/Ajax";

/**
 * Request component
 */
class Request {
    constructor() {}

    makeRequest(successCallBack) {
        ajax.makeRequest()
            .then(response => successCallBack(response))
            .catch(error => console.error(error));
    }
}

export let request = new Request();
