/**
 * Ajax component
 */
class Ajax {
    constructor() {
        this.params = {
            method: 'POST',
            contentType: 'application/json',
            data: {}
        };
    }

    makeRequest(params = this.params)  {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest(),
                body = ``;

            xhr.onload = xhr.onerror = () => {
                if (xhr.status === 200) {
                    try {
                        let response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch(e) {
                        reject(`Invalid JSON data. Maybe return Fatal Error on PHP: ${e}`);
                    }
                } else {
                    reject(`Server Error: ${xhr.status}`);
                }

            };

            xhr.open(params.method, params.url, true);

            switch(params.contentType) {
                case 'x-www-form-urlencoded':
                    let i = 0;

                    for (let param in params.data) {
                        body += `${i>0 ? `&${param}` : param}=${encodeURIComponent(params.data[param])}`;
                        i++;
                    }

                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
                    break;
                default:
                    body = JSON.stringify(params.data);
                    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            }


            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.send(body);
        });
    };

    buildParams(params) {
        for (let filterName in params) {
            if (params.hasOwnProperty(filterName)) {
                this.params[filterName] = params[filterName];
            }
        }
    }
}

export let ajax = new Ajax();
