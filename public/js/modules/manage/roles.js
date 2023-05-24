/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/manage/roles/create.js":
/*!***************************************************!*\
  !*** ./resources/js/admin/manage/roles/create.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 //Create local scope to prevent polluting the global namespace.

$(function () {
  //Cache DOM references
  var $form = $('.content form');

  function initialize() {
    $form.validation({
      submitHandler: handleSubmit.bind(this)
    });
    bindEvents();
  }

  function bindEvents() {
    $form.on('submit', submitAsync.bind(this));
  }

  function handleSubmit() {
    $.post({
      url: $form.attr('action'),
      data: $form.createObject(),
      dataType: 'json',
      success: showSuccessMessage.bind(this),
      error: showErrorMessage.bind(this)
    });
  }

  function submitAsync(e) {
    e.preventDefault();
    $form.valid();
    return false;
  }

  function showSuccessMessage(data) {
    $.alertBox('success', {
      title: 'Success!',
      message: data.message || 'Ticket successfully created!',
      onDestroy: reloadPage.bind(this)
    });
  }

  function showErrorMessage(data) {
    $.alertBox('error', {
      title: 'Oops!',
      message: data.responseJson.message || data.message || 'There was a problem creating the ticket.'
    });
  }

  function reloadPage() {
    location.reload();
  }

  initialize();
});

/***/ }),

/***/ "./resources/js/admin/manage/roles/index.js":
/*!**************************************************!*\
  !*** ./resources/js/admin/manage/roles/index.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(function () {
  var options = {
    datatable: {
      columns: [{
        name: 'Role',
        searchable: true,
        width: 600
      }, {
        name: 'Action',
        searchable: true,
        width: 50,
        orderable: false
      }],
      scrollY: 400,
      scrollCollapse: true,
      pagingType: 'full_numbers',
      dom: "\n                <'dt-content't>\n                <'dt-bot-bar row'\n                    <'col col-sm-12 col-md-4'l>\n                    <'col col-sm-12 col-md-8 row'\n                        <'col col-sm-12 col-md-6 text-center'i>\n                        <'col col-sm-12 col-md-6'p>\n                    >\n                >",
      language: {
        info: '_START_ to _END_ of _TOTAL_',
        paginate: {
          first: '«',
          previous: '‹',
          next: '›',
          last: '»'
        }
      }
    },
    initialHtmlHeight: 712 //Cache DOM reference to avoid jquery to requery the DOM for the element (for efficiency).

  };
  var $dtWrapper = $('.dt-wrapper');
  var $dtTopBar = $dtWrapper.find('.dt-top-bar');
  var $dtBotBar = $dtWrapper.find('.dt-bot-bar');
  var $dtTable = $dtWrapper.find('table');

  function initialize() {
    bindEvents();
    render();
  }

  function bindEvents() {
    $dtTopBar.on('change keyup copy paste cut input', '[type=search]', filterTable.bind(this));
  }

  function render() {
    $dtTable.DataTable(options.datatable);
    restyleDataTable();
  }

  function restyleDataTable() {
    var $scroller = $dtTable.closest('.dataTables_scrollBody');
    var newHeight = $scroller.innerHeight() / options.initialHtmlHeight * $('html').height();
    newHeight = Math.round(newHeight / 100) * 100;
    $scroller.css('min-height', options.datatable.scrollY).css('max-height', options.datatable.scrollY).css('overflow-y', 'scroll');
  }

  function filterTable(e) {
    var $input = $(e.currentTarget);
    $dtTable.DataTable().search($input.val()).draw();
  }

  initialize();
});

/***/ }),

/***/ 6:
/*!****************************************************************************************************!*\
  !*** multi ./resources/js/admin/manage/roles/index.js ./resources/js/admin/manage/roles/create.js ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\admin\manage\roles\index.js */"./resources/js/admin/manage/roles/index.js");
module.exports = __webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\admin\manage\roles\create.js */"./resources/js/admin/manage/roles/create.js");


/***/ })

/******/ });