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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/utils/extension-methods.js":
/*!*************************************************!*\
  !*** ./resources/js/utils/extension-methods.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*!
 * extension-methods v1.0.0
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
;

(function ($, undefined) {
  var options = {
    regex: {
      regularCase: new RegExp('/(\w+)(\s+)(\w+)/g'),
      pascalCase: new RegExp('/(\w+)(\s+)(\w+)/g'),
      snakeCase: new RegExp()
    }
    /**
     * Creates a javascript object using the form fields.
     */

  };

  $.fn.createObject = function (callback) {
    var data = $(this).serializeArray().reduce(function (a, x) {
      a[x.name] = x.value;
      return a;
    }, {});

    if (callback && $.isFunction(callback)) {
      return callback(data) || data;
    } else {
      return data;
    }
  };
  /**
   * Converts a string to kebab case.
   */


  String.prototype.spaceToKebabCase = function () {
    return this.trim().replace(/(\s+)/g, '-').toLowerCase();
  };
  /**
  * Converts a string to kebab case.
  */


  String.prototype.camelToKebabCase = function () {
    return this.trim().replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
  };
})(jQuery);

/***/ }),

/***/ "./resources/js/utils/form-validation.js":
/*!***********************************************!*\
  !*** ./resources/js/utils/form-validation.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*!
 * form-validation v1.0.0
 * A wrapper for jquery validation that uses html5's data annotation.
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
;

(function ($, undefined) {
  var pluginName = "validation";
  var defaults = {
    validation: {
      errorElement: 'small',
      errorClass: 'invalid',
      validClass: 'valid'
    },
    dataAttr: {
      prefix: 'data-validation-'
    }
  };

  function Plugin(element, options) {
    this._element = element;
    this._defaults = defaults;
    this.options = $.extend(true, this._defaults, options);
    this.init();
  }

  $.extend(Plugin.prototype, {
    init: function init() {
      this.buildCache();
      this.buildValidation();
      this.render();
    },
    buildCache: function buildCache() {
      this.$form = $(this._element);
      this.$fields = this.$form.find(':input:enabled:not(button)');
    },
    buildValidation: function buildValidation() {
      var validation = this.$fields.get().map(getFieldRules.bind(this)).filter(hasRules).reduce(aggregateFieldRules.bind(this), {
        rules: {},
        messages: {}
      });
      $.extend(this.options.validation, validation);
    },
    render: function render() {
      this.$form.validate(this.options.validation);
    }
  });

  function getFieldRules(element) {
    var name = element.getAttribute('name');
    var rules = Array.from(element.attributes).filter(isValidationData.bind(this)).reduce(getValidationData.bind(this), {});
    return {
      name: name,
      rules: rules
    };
  }

  function isValidationData(attr) {
    return attr.specified && attr.name.indexOf(this.options.dataAttr.prefix) >= 0;
  }

  function hasRules(fieldData) {
    return Object.keys(fieldData.rules).length > 0 && fieldData.rules.constructor === Object;
  }

  function getValidationData(rules, attr) {
    var ruleName = attr.name.replace(this.options.dataAttr.prefix, '').replace('-', '_').trim().toLowerCase();
    rules[ruleName] = attr.value;
    return rules;
  }

  function aggregateFieldRules(agg, field) {
    var rules = {};

    for (var key in field.rules) {
      rules[key] = true;
    }

    agg.rules[field.name] = rules;
    agg.messages[field.name] = field.rules;
    return agg;
  } // A really lightweight plugin wrapper around the constructor,
  // preventing against multiple instantiations


  $.fn[pluginName] = function (options) {
    this.each(function () {
      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
      }
    });
    return this;
  };
})(jQuery);

/***/ }),

/***/ 2:
/*!***********************************************************************************************!*\
  !*** multi ./resources/js/utils/extension-methods.js ./resources/js/utils/form-validation.js ***!
  \***********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\utils\extension-methods.js */"./resources/js/utils/extension-methods.js");
module.exports = __webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\utils\form-validation.js */"./resources/js/utils/form-validation.js");


/***/ })

/******/ });