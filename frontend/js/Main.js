import { ajax } from 'Classes/Ajax';
import { request } from 'Classes/Request';

class Main {
    static get AJAX_MAKE_BET_URL() {
        return '/admin/makeBet';
    }

    static get AJAX_GET_USER_BALANCE_URL() {
        return '/admin/getUserBalance';
    }

    static get BASICMODAL() {
        return $('#basicModal');
    }

    constructor() {
        this.makeBet();
        this.getUserBalance();
    }

    makeBet() {
        $('.make-bet').submit(function(e) {
            e.preventDefault();

            let amount = $('#amount').val(),
                number = $('#number').val();

            let  params = {
                url:  Main.AJAX_MAKE_BET_URL,
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

    getUserBalance() {
        $('#user-balance').click(function(e) {
            e.preventDefault();

            let  params = {
                url:  Main.AJAX_GET_USER_BALANCE_URL,
                data: {}
            };

            ajax.buildParams(params);
            request.makeRequest(function(responce) {
                Main.BASICMODAL.find('h3').text(`User Balance: ${responce.message}`);
                Main.BASICMODAL.modal('show');
            });
        });
    }
}

export let main = new Main();