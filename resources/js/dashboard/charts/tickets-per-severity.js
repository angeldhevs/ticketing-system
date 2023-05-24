"use strict";

/**
 * Tickets by Severity Pie Chart
 * Dependencies: jQuery, Chart.js
 */

$(function () {

  const CH_MGR = require('../../notification/channel-manager');

  let options = {
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
          backgroundColor: [
            '#6c757d', //Unclassified
            '#28a745', //Low
            '#007bff', //Medium
            '#ffc107', //High
            '#dc3545', //Critical
          ]
        }],
      },
      options: {
        legend: {
          display: true,
          position: 'right',
          align: 'center',
          labels: {
            boxWidth: 15,
          }
        }
      }
    }
  };

  let $root = $('#tickets-by-severity');
  let $canvas = $root.find('canvas');
  let chart = null;

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
    let chartData = {
      datasets: [{
        data: dt.map(d => d.ticket_count),
        backgroundColor: options.chart.data.datasets[0].backgroundColor
      }],
      labels: dt.map(d => d.name)
    };

    if (!chart) {
      let canvas = $canvas.get(0);
      let context = canvas.getContext('2d');
      let settings = $.extend(true, {
        data: chartData
      }, options.chart);
      chart = new Chart(context, settings);
    } else {
      let curData = chart.data.datasets[0].data;
      let newData = chartData.datasets[0].data;

      if (curData.length !== newData.length || !curData.every((d, i) => newData[i] === d)) {
        chart.data = chartData;
        chart.update();
      }
    }
  }

  initialize();
});
