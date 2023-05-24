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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/charts/new-vs-closed-tickets.js":
/*!****************************************************************!*\
  !*** ./resources/js/dashboard/charts/new-vs-closed-tickets.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/**
 * New Vs Closed Tickets Line Graph
 * Dependencies: jQuery, Chart.js
 */

$(function () {
  var CH_MGR = __webpack_require__(/*! ../../notification/channel-manager */ "./resources/js/notification/channel-manager.js");

  var options = {
    daterangepicker: {
      startDate: moment().startOf('month'),
      endDate: moment().endOf('month'),
      opens: 'left',
      timePicker: false,
      showCustomRangeLabel: false,
      alwaysShowCalendars: false,
      autoApply: true,
      locale: {
        separator: ' to ',
        format: 'MMM DD, YYYY'
      },
      ranges: {
        'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Last week': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
        'This week': [moment().startOf('isoWeek'), moment().add(1, 'weeks').subtract(1, 'days')],
        'This month': [moment().startOf('month'), moment().endOf('month')]
      }
    },
    ajax: {
      type: 'GET',
      dataType: 'json',
      success: refreshChart.bind(this)
    },
    chart: {
      type: 'line',
      data: {
        datasets: [{
          label: 'New',
          backgroundColor: '#6c757d',
          borderColor: '#6c757d',
          fill: false,
          data: []
        }, {
          label: 'Closed',
          backgroundColor: '#28a745',
          borderColor: '#28a745',
          fill: false,
          data: []
        }]
      },
      options: {
        responsive: true,
        scales: {
          xAxes: [{
            type: 'time',
            time: {
              unit: 'day'
            },
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Date'
            },
            ticks: {
              major: {
                fontStyle: 'bold',
                fontColor: '#FF0000'
              }
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'count'
            }
          }]
        }
      }
    }
  };
  var dates = [];
  var $root = $('#new-vs-closed-tickets');
  var $picker = $root.find('[name=date-range]');
  var $canvas = $root.find('canvas');
  var chart = null;

  function initialize() {
    $.extend(true, options.ajax, {
      url: $root.data('source')
    });
    bindEvents();
    registerListeners();
    render();
  }

  function bindEvents() {
    $picker.on('apply.daterangepicker', updateDateRange.bind(this));
  }

  function render() {
    $picker.daterangepicker(options.daterangepicker);
    refresh();
  }

  function refresh() {
    requestData(options.daterangepicker.startDate, options.daterangepicker.endDate);
  }

  function registerListeners() {
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.created, refresh.bind(this));
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.updated, refresh.bind(this));
  }

  function refreshChart(dt, status, xhr) {
    $.extend(options.chart.data, {
      labels: dates
    });
    $.extend(options.chart.data.datasets[0], {
      data: dates.map(function (date) {
        var match = dt.find(function (d) {
          return d.date === date;
        });
        return match ? match["new"] : 0;
      })
    });
    $.extend(options.chart.data.datasets[1], {
      data: dates.map(function (date) {
        var match = dt.find(function (d) {
          return d.date === date;
        });
        return match ? match.closed : 0;
      })
    });

    if (!chart) {
      var canvas = $canvas.get(0);
      var context = canvas.getContext('2d');
      context.canvas.width = 1000;
      context.canvas.height = 250;
      chart = new Chart(context, options.chart);
    } else {
      $.extend(chart, {
        data: options.chart.data
      });
      chart.update();
    }
  }

  function updateDateRange(e, picker) {
    requestData(picker.startDate, picker.endDate);
  }

  function requestData(dateFrom, dateTo) {
    dates = [];

    for (var date = dateFrom.clone(); date < dateTo; date.add(1, 'days')) {
      dates.push(date.format('YYYY-MM-DD'));
    }

    $.extend(options.ajax, {
      data: {
        from: dateFrom.format('YYYY-MM-DD'),
        to: dateTo.format('YYYY-MM-DD')
      }
    });
    $.ajax(options.ajax);
  }

  initialize();
});

/***/ }),

/***/ "./resources/js/dashboard/charts/tickets-per-severity.js":
/*!***************************************************************!*\
  !*** ./resources/js/dashboard/charts/tickets-per-severity.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/**
 * Tickets by Severity Pie Chart
 * Dependencies: jQuery, Chart.js
 */

$(function () {
  var CH_MGR = __webpack_require__(/*! ../../notification/channel-manager */ "./resources/js/notification/channel-manager.js");

  var options = {
    ajax: {
      type: 'GET',
      dataType: 'json',
      success: refreshChart.bind(this)
    },
    chart: {
      type: 'doughnut',
      data: {
        datasets: [{
          label: 'Status',
          backgroundColor: ['#6c757d', //Unclassified
          '#28a745', //Low
          '#007bff', //Medium
          '#ffc107', //High
          '#dc3545']
        }]
      },
      options: {
        legend: {
          display: true,
          position: 'right',
          align: 'center',
          labels: {
            boxWidth: 15
          }
        }
      }
    }
  };
  var $root = $('#tickets-by-severity');
  var $canvas = $root.find('canvas');
  var chart = null;

  function initialize() {
    $.extend(true, options.ajax, {
      url: $root.data('source')
    });
    registerListeners();
    render();
  }

  function render() {
    $.ajax(options.ajax);
  }

  function registerListeners() {
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.created, render.bind(this));
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.updated, render.bind(this));
  }

  function refreshChart(dt, status, xhr) {
    var chartData = {
      datasets: [{
        data: dt.map(function (d) {
          return d.ticket_count;
        }),
        backgroundColor: options.chart.data.datasets[0].backgroundColor
      }],
      labels: dt.map(function (d) {
        return d.name;
      })
    };

    if (!chart) {
      var canvas = $canvas.get(0);
      var context = canvas.getContext('2d');
      var settings = $.extend(true, {
        data: chartData
      }, options.chart);
      chart = new Chart(context, settings);
    } else {
      var curData = chart.data.datasets[0].data;
      var newData = chartData.datasets[0].data;

      if (curData.length !== newData.length || !curData.every(function (d, i) {
        return newData[i] === d;
      })) {
        chart.data = chartData;
        chart.update();
      }
    }
  }

  initialize();
});

/***/ }),

/***/ "./resources/js/dashboard/charts/tickets-per-status.js":
/*!*************************************************************!*\
  !*** ./resources/js/dashboard/charts/tickets-per-status.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/**
 * Tickets by Status Pie Chart
 * Dependencies: jQuery, Chart.js
 */

$(function () {
  var CH_MGR = __webpack_require__(/*! ../../notification/channel-manager */ "./resources/js/notification/channel-manager.js");

  var options = {
    ajax: {
      type: 'GET',
      dataType: 'json',
      success: refreshChart.bind(this)
    },
    chart: {
      type: 'doughnut',
      data: {
        datasets: [{
          label: 'Status',
          backgroundColor: ['#6c757d', //New
          '#007bff', //Open
          '#17a2b8', //In Progress
          '#dc3545', //Needs More Info
          '#ffc107', //Resolved
          '#28a745']
        }]
      },
      options: {
        legend: {
          display: true,
          position: 'right',
          align: 'center',
          labels: {
            boxWidth: 15
          }
        }
      }
    },
    apex: {
      colors: ['#6c757d', //New
      '#007bff', //Open
      '#17a2b8', //In Progress
      '#dc3545', //Needs More Info
      '#ffc107', //Resolved
      '#28a745'],
      chart: {
        type: 'donut'
      },
      dataLabels: {
        enabled: true,
        formatter: function formatter(val) {
          return Math.round(val) + "%";
        }
      },
      plotOptions: {
        pie: {
          expandOnClick: false,
          donut: {
            size: '60%'
          }
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    }
  };
  var $root = $('#tickets-by-status');
  var $canvas = $root.find('canvas');
  var chart = null;

  function initialize() {
    $.extend(true, options.ajax, {
      url: $root.data('source')
    });
    registerListeners();
    render();
  }

  function render() {
    $.ajax(options.ajax);
  }

  function registerListeners() {
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.created, render.bind(this));
    CH_MGR.channels.ticket.listen(CH_MGR.events.ticket.updated, render.bind(this));
  }

  function refreshChart(dt, status, xhr) {
    var chartData = {
      datasets: [{
        data: dt.map(function (d) {
          return d.ticket_count;
        }),
        backgroundColor: options.chart.data.datasets[0].backgroundColor
      }],
      labels: dt.map(function (d) {
        return d.name;
      })
    };

    if (!chart) {
      var canvas = $canvas.get(0);
      var context = canvas.getContext('2d');
      var settings = $.extend(true, {
        data: chartData
      }, options.chart);
      chart = new Chart(context, settings);
    } else {
      var curData = chart.data.datasets[0].data;
      var newData = chartData.datasets[0].data;

      if (curData.length !== newData.length || !curData.every(function (d, i) {
        return newData[i] === d;
      })) {
        chart.data = chartData;
        chart.update();
      }
    }
  }

  initialize();
});

/***/ }),

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

/***/ 8:
/*!************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/dashboard/charts/tickets-per-status.js ./resources/js/dashboard/charts/tickets-per-severity.js ./resources/js/dashboard/charts/new-vs-closed-tickets.js ***!
  \************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\dashboard\charts\tickets-per-status.js */"./resources/js/dashboard/charts/tickets-per-status.js");
__webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\dashboard\charts\tickets-per-severity.js */"./resources/js/dashboard/charts/tickets-per-severity.js");
module.exports = __webpack_require__(/*! C:\Projects\Freelance\ticketing-system\resources\js\dashboard\charts\new-vs-closed-tickets.js */"./resources/js/dashboard/charts/new-vs-closed-tickets.js");


/***/ })

/******/ });