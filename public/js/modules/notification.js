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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/notification/channel-manager.js":
/*!******************************************************!*\
  !*** ./resources/js/notification/channel-manager.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = {
  channels: {
    user: Echo["private"]('App.User.' + __App.User.id),
    ticket: Echo.channel('Ticket')
  },
  events: {
    ticket: {
      created: '.Ticket.Created',
      updated: '.Ticket.Updated'
    }
  }
};

/***/ }),

/***/ "./resources/js/notification/notification-manager.js":
/*!***********************************************************!*\
  !*** ./resources/js/notification/notification-manager.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(function () {
  var CH_MGR = __webpack_require__(/*! ../notification/channel-manager */ "./resources/js/notification/channel-manager.js");

  var ITEM_TEMPLATE = "<a class=\"dropdown-item unread\" href=\"{{&url}}\">\n        <span class=\"notification-message\">{{message}}</span>\n        <small class=\"notification-time\">{{timestamp}}</small>\n      </a>";
  var NOTIF_COUNT = "notification-count";
  var $root = $(".notifications");
  var $trigger = $root.find(".notification-toggle");
  var $counters = $root.find(".notification-count");
  var $content = $root.find(".dropdown-content");

  function initialize() {
    bindEvents();
    registerListeners();
    render();
  }

  function bindEvents() {
    $root.on("shown.bs.dropdown", getUnreadNotifications.bind(this));
    $content.on("click", "a", openNotification.bind(this));
  }

  function render() {
    $root.removeData('notifications');
    getUnreadNotifications({
      relatedTarget: $trigger
    });
  }

  function registerListeners() {
    CH_MGR.channels.user.notification(render.bind(this));
  }

  function getUnreadNotifications(e) {
    var $target = $(e.relatedTarget);
    $.get($target.data("resource-url"), renderNotifications.bind(this));
  }

  function renderNotifications(notifications) {
    if ($root.data("notifications")) {
      return false;
    }

    var hasNotifications = notifications.length > 0;
    $counters.data(NOTIF_COUNT, notifications.length).text(notifications.length);
    $content.toggleClass("no-notifications", !hasNotifications).find(":not(:first)").remove();
    notifications.map(createNotificationItem.bind(this)).reduce(function (container, item) {
      container.append(item);
      return container;
    }, $content);
    $root.data("notifications", notifications);
  }

  function openNotification(e) {
    var $target = $(e.currentTarget);

    if ($target.hasClass("unread")) {
      var notification = $target.data("notification");
      var count = $counters.data(NOTIF_COUNT); //Mark notification as read if successfully posted.

      $.post(notification.read_url, function () {
        $target.removeClass("unread");
        count--;
        $counters.data(NOTIF_COUNT, count).text(count);
      }.bind(this));
    }

    return true;
  }

  function createNotificationItem(notification) {
    console.log(notification);
    var view = {
      url: notification.data.url,
      message: notification.data.message,
      timestamp: moment(notification.created_at).fromNow()
    };
    var $notification = $(mustache.render(unescape(ITEM_TEMPLATE), view));
    $notification.data("notification", notification);
    return $notification;
  }

  initialize();
});

/***/ }),

/***/ 9:
/*!*****************************************************************!*\
  !*** multi ./resources/js/notification/notification-manager.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\notification\notification-manager.js */"./resources/js/notification/notification-manager.js");


/***/ })

/******/ });