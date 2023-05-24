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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
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

/***/ "./resources/js/tickets/index.js":
/*!***************************************!*\
  !*** ./resources/js/tickets/index.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

$(function () {
  var CH_MGR = __webpack_require__(/*! ../notification/channel-manager */ "./resources/js/notification/channel-manager.js");

  var options = {
    datatable: {
      columns: [{
        data: "data.ticket_number",
        title: "Ticket #",
        type: "number",
        searchable: true,
        className: "ticket-number",
        width: 80,
        render: {
          _: function _(data, type, obj) {
            return "<a href=\"".concat(obj.links.self, "\"\n                class=\"view-ticket\"\n                data-toggle=\"modal\"\n                data-target=\"#ticket-modal\"\n                data-mode=\"view\"\n                data-resource-url=\"").concat(obj.links.self, "\"\n                >").concat(data, "</a>");
          },
          sort: function sort(data) {
            return parseInt(data);
          }
        }
      }, {
        data: "data.title",
        title: "Title",
        className: "ticket-title",
        searchable: true,
        width: 70
      }, {
        data: "data.assignee",
        title: "Assignee",
        className: "ticket-assignee",
        searchable: true,
        width: 150,
        render: {
          _: function _(data, type, obj) {
            return data === null ? '<i>- Unassigned -</i>' : data.name;
          },
          sort: function sort(data, type, obj) {
            return data === null ? 'Unassigned' : data.name;
          }
        }
      }, {
        data: "data.status.name",
        title: "Status",
        className: "ticket-status",
        searchable: true,
        width: 60,
        render: {
          _: function _(data) {
            return "<span class=\"badge status-".concat(data.spaceToKebabCase(), "\">").concat(data, "</span>");
          },
          sort: function sort(data) {
            return data;
          }
        }
      }, {
        data: "data.date_updated",
        title: "Last Updated",
        className: "ticket-last-update",
        searchable: true,
        width: 180,
        render: {
          _: function _(data) {
            return moment(data).fromNow();
          },
          sort: function sort(data) {
            return moment(data).format('x');
          }
        }
      }, {
        data: "links",
        title: "Action",
        className: "ticket-action",
        searchable: false,
        width: 50,
        orderable: false,
        render: function render(data, type, obj) {
          var links = "<a href=\"".concat(obj.links.self, "\"\n              class=\"fa fa-info-circle view-ticket\"\n              data-toggle=\"modal\"\n              data-target=\"#ticket-modal\"\n              data-mode=\"view\"\n              data-resource-url=\"").concat(obj.links.self, "\"\n              title=\"View Ticket Details\">");

          if (!obj.data.assignee) {
            links += "<a href=\"".concat(obj.links.self, "\"\n                class=\"ml-2 fa fa-user-cog\"\n                data-toggle=\"modal\"\n                data-target=\"#ticket-modal\"\n                data-mode=\"assign\"\n                data-resource-url=\"").concat(obj.links.self, "\"\n                title=\"Assign Ticket\">");
          }

          return links;
        }
      }],
      scrollY: 400,
      scrollCollapse: true,
      order: [[4, "desc"]],
      pagingType: "full_numbers",
      dom: "\n        <'dt-content't>\n        <'dt-bot-bar row'\n            <'col col-sm-12 col-md-4'l>\n            <'col col-sm-12 col-md-8 row'\n                <'col col-sm-12 col-md-6 text-center'i>\n                <'col col-sm-12 col-md-6'p>\n            >\n        >",
      language: {
        info: "_START_ to _END_ of _TOTAL_",
        paginate: {
          first: "«",
          previous: "‹",
          next: "›",
          last: "»"
        },
        processing: "<div class=\"spinner-border spinner-border-lg\" role=\"status\"></div>",
        loadingRecords: 'Fetching records from the server. Please wait...'
      }
    },
    initialHtmlHeight: 712,
    momentDateFormat: "YYYY-MM-DD HH:mm:ss"
  }; //Cache DOM reference to avoid jquery to requery the DOM for the element (for efficiency).

  var $dtWrapper = $(".dt-wrapper");
  var $dtTopBar = $dtWrapper.find(".dt-top-bar");
  var $dtTable = $dtWrapper.find("table");
  var $modal = $('#ticket-modal');
  var datatable = $dtTable.DataTable($.extend(true, {
    ajax: {
      url: $dtTable.data("source"),
      beforeSend: function beforeSend(xhr) {
        xhr.setRequestHeader("Authorization", "Bearer " + $('meta[name="api-token"]').attr("content"));
      },
      dataSrc: ""
    }
  }, options.datatable));

  function initialize() {
    $.fn.dataTable.moment(options.momentDateFormat);
    bindEvents();
    registerListeners();
    render();
  }

  function bindEvents() {
    $dtTopBar.on("change keyup copy paste cut input", "[type=search]", filterTable.bind(this));
    $modal.on('ticket.create', hideModal.bind(this));
    $modal.on('ticket.update', hideModal.bind(this));
    $modal.on('ticket.assign', hideModal.bind(this));
  }

  function registerListeners() {
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.created, updateDatatables.bind(this));
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.updated, updateDatatables.bind(this));
    window.addEventListener('popstate', render.bind(this));
  }

  function render() {
    restyleDataTable();
    tryLoadTicket();
  }

  function tryLoadTicket() {
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');

    if (id) {
      var url = $dtTable.data('source') + "/" + id;
      $('<a/>').data('resource-url', url).data('mode', 'view').attr('data-toggle', 'modal').attr('data-target', '#ticket-modal').appendTo($dtWrapper).click();
    }
  }

  function restyleDataTable() {
    var $scroller = $dtTable.closest(".dataTables_scrollBody");
    var newHeight = $scroller.innerHeight() / options.initialHtmlHeight * $("html").height();
    newHeight = Math.round(newHeight / 100) * 100;
    $scroller.css("min-height", options.datatable.scrollY).css("max-height", options.datatable.scrollY).css("overflow-y", "scroll");
  }

  function filterTable(e) {
    var $input = $(e.currentTarget);
    $dtTable.DataTable().search($input.val()).draw();
  }

  function addNewRecord(e, data, status) {
    $modal.modal('hide'); // datatable.row.add(data).draw();
  }

  function updateDataRow(e, newData, status) {
    $modal.modal('hide'); // datatable
    //   .row(function (index, oldData, node) {
    //     return oldData.data.ticket_number === newData.data.ticket_number;
    //   })
    //   .data(newData);
    // datatable
    //   .order([4, 'desc'])
    //   .draw();
  }

  function updateDatatables(data) {
    datatable.ajax.reload();
  }

  function hideModal() {
    $modal.modal('hide');
  }

  initialize();
});

/***/ }),

/***/ 3:
/*!*********************************************!*\
  !*** multi ./resources/js/tickets/index.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\tickets\index.js */"./resources/js/tickets/index.js");


/***/ })

/******/ });