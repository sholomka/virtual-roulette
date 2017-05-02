import { ajax } from 'Classes/Ajax';
import { request } from 'Classes/Request';

class Main {
    /**
     * AJAX url для ставки
     *
     * @returns {string}
     * @constructor
     */
    static get AJAX_MAKE_BET_URL() {
        return '/admin/makeBet';
    }

    /**
     * AJAX url для получения баланса
     *
     * @returns {string}
     * @constructor
     */
    static get AJAX_GET_USER_BALANCE_URL() {
        return '/admin/getUserBalance';
    }

    /**
     *  Всплывающее окно
     *
     * @returns {jQuery|HTMLElement}
     * @constructor
     */
    static get BASICMODAL() {
        return $('#basicModal');
    }

    /**
     * constructor
     */
    constructor() {
        this.makeBet();
        this.getUserBalance();
    }

    /**
     * Сделать ставку
     */
    makeBet() {
        $('.make-bet').on('input', '#amount', function() {
            $('.make-bet')
                .find('button[type="submit"]')
                .prop('disabled', $(this).val().trim() === '');
        });

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

    /**
     * Получить баланс юзера
     */
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