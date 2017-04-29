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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Files = function () {
    function Files() {
        _classCallCheck(this, Files);
    }

    _createClass(Files, [{
        key: 'upload',
        value: function upload(data) {
            var xhr = new XMLHttpRequest();

            // обработчик для закачки
            xhr.upload.onprogress = function (event) {
                console.log(event.loaded + ' / ' + event.total);
            };

            // обработчики успеха и ошибки
            // если status == 200, то это успех, иначе ошибка
            xhr.onload = xhr.onerror = function () {
                if (this.status == 200) {
                    if (typeof data.callback === 'function') {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            data.callback(response);
                        } catch (e) {
                            console.error('Invalid JSON data. Maybe return Fatal Error on PHP: ' + e);
                        }
                    }

                    console.log("success");
                } else {
                    console.log("error " + this.status);
                }
            };

            var formData = new FormData();

            if (_typeof(data.file) === 'object') {
                formData.append("image", data.file);
            }

            xhr.open("POST", data.url, true);
            xhr.send(formData);
        }
    }]);

    return Files;
}();

var files = exports.files = new Files();

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.main = undefined;

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _Files = __webpack_require__(0);

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Main = function () {
    _createClass(Main, null, [{
        key: 'AJAX_USER_UPLOAD_FILE_URL',
        get: function get() {
            return '/edit/imageUpload';
        }
    }, {
        key: 'BASICMODAL',
        get: function get() {
            return $('#basicModal');
        }
    }, {
        key: 'ADD_TASK',
        get: function get() {
            return $('.add-task');
        }
    }]);

    function Main() {
        _classCallCheck(this, Main);

        this.tablePaginationAndSortInit();
        this.changeImage();
        this.preview();
    }

    _createClass(Main, [{
        key: 'preview',
        value: function preview() {
            Main.ADD_TASK.on('click', '.preview', function () {
                var name = Main.ADD_TASK.find('input[name="name"]').val(),
                    email = Main.ADD_TASK.find('input[name="email"]').val(),
                    description = Main.ADD_TASK.find('input[name="description"]').val(),
                    fileName = Main.ADD_TASK.find('img').attr('src'),
                    imagePath = '' + fileName;

                var img = new Image();
                img.src = imagePath;
                img.width = 320;
                img.height = 240;

                Main.BASICMODAL.find('.name').text(name);
                Main.BASICMODAL.find('.email').text(email);
                Main.BASICMODAL.find('.description').text(description);
                Main.BASICMODAL.find('.image').html(img);
                Main.BASICMODAL.modal('show');
            });
        }
    }, {
        key: 'tablePaginationAndSortInit',
        value: function tablePaginationAndSortInit() {
            $('#main-table, #admin-table').dataTable({
                "pageLength": 3,
                "lengthChange": false
            });
        }
    }, {
        key: 'changeImage',
        value: function changeImage() {
            var _this = this;

            $('.add-task').on('change', 'input[type=file]', function (e) {
                var file = $(e.currentTarget)[0].files[0],
                    image = file.name,
                    callback = function callback(response) {
                    var imagePath = '/images/' + response.filename;

                    if ($('.add-task img').size() > 0) {
                        $('.add-task img').attr('src', imagePath);
                    } else {
                        var img = new Image();
                        img.src = imagePath;
                        img.width = 320;
                        img.height = 240;

                        $('.btn-file').after(img);
                    }
                };

                _this.filesUploadData = {
                    file: file,
                    callback: callback,
                    url: Main.AJAX_USER_UPLOAD_FILE_URL
                };

                _this.filesUpload();
            });
        }
    }, {
        key: 'filesUpload',
        value: function filesUpload() {
            if (this.filesUploadData.file) {
                _Files.files.upload(this.filesUploadData);
            }
        }
    }]);

    return Main;
}();

var main = exports.main = new Main();

/***/ })
/******/ ]);