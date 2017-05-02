import { ajax } from 'Classes/Ajax';
import { request } from 'Classes/Request';

class Main {
    static get AJAX_USER_CROP_PHOTO_URL() {
        return '/admin/makeBet';
    }

    static get BASICMODAL() {
        return $('#basicModal');
    }

    constructor() {
        this.makeBet();
    }

    makeBet() {
        $('.make-bet').submit(function(e) {
            e.preventDefault();

            let amount = $('#amount').val(),
                number = $('#number').val();

            let  params = {
                url:  Main.AJAX_USER_CROP_PHOTO_URL,
                data: {
                    T: 'n',
                    I: number,
                    C: '1',
                    K: amount,
                }
            };


            ajax.buildParams(params);
            request.makeRequest(function(responce) {

                Main.BASICMODAL.find('h3').text(responce.message);
                Main.BASICMODAL.modal('show');



            });
        });
    }

}

export let main = new Main();