/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Ajax component
 */
var Ajax = function () {
    function Ajax() {
        _classCallCheck(this, Ajax);

        this.params = {
            method: 'POST',
            contentType: 'application/json',
            data: {}
        };
    }

    _createClass(Ajax, [{
        key: 'makeRequest',
        value: function makeRequest() {
            var params = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.params;

            return new Promise(function (resolve, reject) {
                var xhr = new XMLHttpRequest(),
                    body = '';

                xhr.onload = xhr.onerror = function () {
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            resolve(response);
                        } catch (e) {
                            reject('Invalid JSON data. Maybe return Fatal Error on PHP: ' + e);
                        }
                    } else {
                        reject('Server Error: ' + xhr.status);
                    }
                };

                xhr.open(params.method, params.url, true);

                switch (params.contentType) {
                    case 'x-www-form-urlencoded':
                        var i = 0;

                        for (var param in params.data) {
                            body += (i > 0 ? '&' + param : param) + '=' + encodeURIComponent(params.data[param]);
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
        }
    }, {
        key: 'buildParams',
        value: function buildParams(params) {
            for (var filterName in params) {
                if (params.hasOwnProperty(filterName)) {
                    this.params[filterName] = params[filterName];
                }
            }
        }
    }]);

    return Ajax;
}();

var ajax = exports.ajax = new Ajax();

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.request = undefined;

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _Ajax = __webpack_require__(0);

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Request component
 */
var Request = function () {
    function Request() {
        _classCallCheck(this, Request);
    }

    _createClass(Request, [{
        key: "makeRequest",
        value: function makeRequest(successCallBack) {
            _Ajax.ajax.makeRequest().then(function (response) {
                return successCallBack(response);
            }).catch(function (error) {
                return console.error(error);
            });
        }
    }]);

    return Request;
}();

var request = exports.request = new Request();

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.main = undefined;

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _Ajax = __webpack_require__(0);

var _Request = __webpack_require__(1);

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Main = function () {
    _createClass(Main, null, [{
        key: 'AJAX_USER_CROP_PHOTO_URL',
        get: function get() {
            return '/admin/makeBet';
        }
    }, {
        key: 'BASICMODAL',
        get: function get() {
            return $('#basicModal');
        }
    }]);

    function Main() {
        _classCallCheck(this, Main);

        this.makeBet();
    }

    _createClass(Main, [{
        key: 'makeBet',
        value: function makeBet() {
            $('.make-bet').submit(function (e) {
                e.preventDefault();

                var amount = $('#amount').val(),
                    number = $('#number').val();

                var params = {
                    url: Main.AJAX_USER_CROP_PHOTO_URL,
                    data: {
                        T: 'n',
                        I: number,
                        C: '1',
                        K: amount
                    }
                };

                _Ajax.ajax.buildParams(params);
                _Request.request.makeRequest(function (responce) {

                    Main.BASICMODAL.find('h3').text(responce.message);
                    Main.BASICMODAL.modal('show');
                });
            });
        }
    }]);

    return Main;
}();

var main = exports.main = new Main();

/***/ })
/******/ ]);