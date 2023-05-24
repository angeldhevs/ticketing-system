"use strict";

/**
 * New Vs Closed Tickets Line Graph
 * Dependencies: jQuery, Chart.js
 */

$(function () {

  const CH_MGR = require('../../notification/channel-manager');

  let options = {
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
          },
          {
            label: 'Closed',
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            fill: false,
            data: []
          }
        ]
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

  let dates = [];

  let $root = $('#new-vs-closed-tickets');
  let $picker = $root.find('[name=date-range]');
  let $canvas = $root.find('canvas');
  let chart = null;

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
    requestData(options.daterangepicker.startDate, options.daterangepicker.endDate)
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
        let match = dt.find(function (d) {
          return d.date === date;
        });

        return match ? match.new : 0;
      })
    });

    $.extend(options.chart.data.datasets[1], {
      data: dates.map(function (date) {
        let match = dt.find(function (d) {
          return d.date === date;
        });

        return match ? match.closed : 0;
      })
    });

    if (!chart) {
      let canvas = $canvas.get(0);
      let context = canvas.getContext('2d');
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
    for (let date = dateFrom.clone(); date < dateTo; date.add(1, 'days')) {
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
