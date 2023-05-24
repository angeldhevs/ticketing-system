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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/components/dialog-box.js":
/*!***********************************************!*\
  !*** ./resources/js/components/dialog-box.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*!
 * dialog-box v1.0.0
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
(function ($, undefined) {
  if ($ === undefined) {
    throw new Error('Cannot initialize plugin. jquery is not loaded.');
  }

  if ($.fn.confirm === undefined) {
    throw new Error('Cannot initialize jquery-confirm extension. jquery-confirm not found.');
  }

  var options = {
    defaults: {
      animation: 'opacity',
      closeAnimation: 'opacity',
      escapeKey: true,
      backgroundDismiss: true,
      typeAnimated: true,
      draggable: false
    },
    types: {
      success: {
        type: 'green'
      },
      warn: {
        type: 'orange'
      },
      error: {
        type: 'red'
      },
      info: {
        type: 'blue'
      }
    }
  };
  var dialogs = {
    confirm: {
      show: function show(type, settings) {
        $.confirm(getExtendedSettings(type, settings));
      },
      success: function success(settings) {
        this.show('success', settings);
      },
      error: function error(settings) {
        this.show('error', settings);
      },
      warn: function warn(settings) {
        this.show('warn', settings);
      },
      info: function info(settings) {
        this.show('info', settings);
      }
    },
    alert: {
      show: function show(type, settings) {
        $.alert(getExtendedSettings(type, settings));
      },
      success: function success(settings) {
        this.show('success', settings);
      },
      error: function error(settings) {
        this.show('error', settings);
      },
      warn: function warn(settings) {
        this.show('warn', settings);
      },
      info: function info(settings) {
        this.show('info', settings);
      }
    }
  };

  function getExtendedSettings(type, settings) {
    return $.extend(true, {}, options.defaults, settings, options.types[type]);
  }

  $.confirmBox = function (type, settings) {
    if (_typeof(type) === (typeof string === "undefined" ? "undefined" : _typeof(string)) && !dialogs.confirm.hasOwnProperty(type.toLowerCase())) {
      throw new Error('Unknown confirmation message type: ', type);
    }

    return dialogs.confirm[type](settings);
  };

  $.alertBox = function (type, settings) {
    if (_typeof(type) === (typeof string === "undefined" ? "undefined" : _typeof(string)) && !dialogs.confirm.hasOwnProperty(type.toLowerCase())) {
      throw new Error('Unknown alert message type: ', type);
    }

    return dialogs.alert[type](settings);
  };
})(jQuery);

/***/ }),

/***/ "./resources/js/components/navigation.js":
/*!***********************************************!*\
  !*** ./resources/js/components/navigation.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var $body = $('body');
  var $navbar = $body.find('nav.navbar');

  function initialize() {
    bindEvents();
    render();
  }

  function bindEvents() {
    $navbar.on('click', '[data-target]', toggleNav.bind(this));
  }

  function render() {}

  function toggleNav(evt) {
    var $toggler = $(evt.currentTarget);
    var $target = $body.find($toggler.data('target'));
    $toggler.find('.fa').toggleClass('fa-flip-horizontal');
    $target.toggleClass($toggler.data('toggle-class'));
  }

  initialize();
});

/***/ }),

/***/ "./resources/js/components/spinner.js":
/*!********************************************!*\
  !*** ./resources/js/components/spinner.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*!
 * spinner v1.0.0
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
;

(function ($, undefined) {
  if ($ === undefined) {
    throw new Error('Cannot initialize plugin. jQuery is not loaded.');
  } // let $body = $('body');
  // let $spinner = $body.find('.spinner');
  // if (!$spinner.get(0)) {
  //     throw new Error("Cannot initialize spinner. #spinner not found!");
  // }


  $.spinner = function (action, parent, text) {
    var $spinner = $(parent || 'body').find('.spinner');

    if (text !== undefined && _typeof(text) === (typeof string === "undefined" ? "undefined" : _typeof(string)) && text.length > 0) {
      $spinner.find('.text').text(text);
    }

    switch (action) {
      case "show":
        $spinner.addClass("show");
        break;

      case "hide":
        $spinner.removeClass("show");
        break;

      case "hide":
        $spinner.toggleClass("show");
        break;

      default:
        $spinner.toggleClass("show");
        break;
    }
  };
})(jQuery);

/***/ }),

/***/ 1:
/*!**********************************************************************************************************************************!*\
  !*** multi ./resources/js/components/dialog-box.js ./resources/js/components/spinner.js ./resources/js/components/navigation.js ***!
  \**********************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\components\dialog-box.js */"./resources/js/components/dialog-box.js");
__webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\components\spinner.js */"./resources/js/components/spinner.js");
module.exports = __webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\components\navigation.js */"./resources/js/components/navigation.js");


/***/ })

/******/ });