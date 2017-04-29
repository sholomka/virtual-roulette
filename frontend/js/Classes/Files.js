class Files {
    constructor() {}

    upload(data) {
        let xhr = new XMLHttpRequest();

        // обработчик для закачки
        xhr.upload.onprogress = function(event) {
            console.log(event.loaded + ' / ' + event.total);
        };

        // обработчики успеха и ошибки
        // если status == 200, то это успех, иначе ошибка
        xhr.onload = xhr.onerror = function() {
            if (this.status == 200) {
                if (typeof data.callback === 'function') {
                    try {
                        let response = JSON.parse(xhr.responseText);
                        data.callback(response);
                    } catch(e) {
                        console.error(`Invalid JSON data. Maybe return Fatal Error on PHP: ${e}`);
                    }

                }

                console.log("success");
            } else {
                console.log("error " + this.status);
            }
        };

        let formData = new FormData();

        if (typeof data.file === 'object') {
            formData.append("image", data.file);
        }

        xhr.open("POST", data.url, true);
        xhr.send(formData);
    };
}

export let files = new Files();