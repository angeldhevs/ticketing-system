$(function () {

  const CH_MGR = require('../notification/channel-manager');

  let options = {
    datatable: {
      columns: [{
          data: "data.ticket_number",
          title: "Ticket #",
          type: "number",
          searchable: true,
          className: "ticket-number",
          width: 80,
          render: {
            _: function (data, type, obj) {
              return `<a href="${obj.links.self}"
                class="view-ticket"
                data-toggle="modal"
                data-target="#ticket-modal"
                data-mode="view"
                data-resource-url="${obj.links.self}"
                >${data}</a>`;
            },
            sort: function (data) {
              return parseInt(data);
            }
          }
        },
        {
          data: "data.title",
          title: "Title",
          className: "ticket-title",
          searchable: true,
          width: 70
        },
        {
          data: "data.assignee",
          title: "Assignee",
          className: "ticket-assignee",
          searchable: true,
          width: 150,
          render: {
            _: function (data, type, obj) {
              return data === null ? '<i>- Unassigned -</i>' : data.name;
            },
            sort: function (data, type, obj) {
              return data === null ? 'Unassigned' : data.name;
            }
          }
        },
        {
          data: "data.status.name",
          title: "Status",
          className: "ticket-status",
          searchable: true,
          width: 60,
          render: {
            _: function (data) {
              return `<span class="badge status-${data.spaceToKebabCase()}">${data}</span>`;
            },
            sort: function (data) {
              return data;
            }
          }
        },
        {
          data: "data.date_updated",
          title: "Last Updated",
          className: "ticket-last-update",
          searchable: true,
          width: 180,
          render: {
            _: function (data) {
              return moment(data).fromNow();
            },
            sort: function (data) {
              return moment(data).format('x');
            }
          }
        },
        {
          data: "links",
          title: "Action",
          className: "ticket-action",
          searchable: false,
          width: 50,
          orderable: false,
          render: function (data, type, obj) {
            let links = `<a href="${obj.links.self}"
              class="fa fa-info-circle view-ticket"
              data-toggle="modal"
              data-target="#ticket-modal"
              data-mode="view"
              data-resource-url="${obj.links.self}"
              title="View Ticket Details">`;
            if (!obj.data.assignee) {
              links += `<a href="${obj.links.self}"
                class="ml-2 fa fa-user-cog"
                data-toggle="modal"
                data-target="#ticket-modal"
                data-mode="assign"
                data-resource-url="${obj.links.self}"
                title="Assign Ticket">`;
            }

            return links;
          }
        }
      ],
      scrollY: 400,
      scrollCollapse: true,
      order: [
        [4, "desc"]
      ],
      pagingType: "full_numbers",
      dom: `
        <'dt-content't>
        <'dt-bot-bar row'
            <'col col-sm-12 col-md-4'l>
            <'col col-sm-12 col-md-8 row'
                <'col col-sm-12 col-md-6 text-center'i>
                <'col col-sm-12 col-md-6'p>
            >
        >`,
      language: {
        info: "_START_ to _END_ of _TOTAL_",
        paginate: {
          first: "«",
          previous: "‹",
          next: "›",
          last: "»"
        },
        processing: `<div class="spinner-border spinner-border-lg" role="status"></div>`,
        loadingRecords: 'Fetching records from the server. Please wait...'
      }
    },
    initialHtmlHeight: 712,
    momentDateFormat: "YYYY-MM-DD HH:mm:ss"
  };

  //Cache DOM reference to avoid jquery to requery the DOM for the element (for efficiency).
  let $dtWrapper = $(".dt-wrapper");
  let $dtTopBar = $dtWrapper.find(".dt-top-bar");
  let $dtTable = $dtWrapper.find("table");
  let $modal = $('#ticket-modal');
  let datatable = $dtTable.DataTable($.extend(
    true, {
      ajax: {
        url: $dtTable.data("source"),
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + $('meta[name="api-token"]').attr("content")
          );
        },
        dataSrc: ""
      }
    },
    options.datatable
  ));

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
    let urlParams = new URLSearchParams(window.location.search);
    let id = urlParams.get('id');
    if (id) {
      let url = $dtTable.data('source') + "/" + id;
      $('<a/>')
        .data('resource-url', url)
        .data('mode', 'view')
        .attr('data-toggle', 'modal')
        .attr('data-target', '#ticket-modal')
        .appendTo($dtWrapper)
        .click();
    }
  }

  function restyleDataTable() {
    let $scroller = $dtTable.closest(".dataTables_scrollBody");
    let newHeight =
      ($scroller.innerHeight() / options.initialHtmlHeight) *
      $("html").height();
    newHeight = Math.round(newHeight / 100) * 100;
    $scroller
      .css("min-height", options.datatable.scrollY)
      .css("max-height", options.datatable.scrollY)
      .css("overflow-y", "scroll");
  }

  function filterTable(e) {
    let $input = $(e.currentTarget);
    $dtTable
      .DataTable()
      .search($input.val())
      .draw();
  }

  function addNewRecord(e, data, status) {
    $modal.modal('hide');
    // datatable.row.add(data).draw();
  }

  function updateDataRow(e, newData, status) {
    $modal.modal('hide');
    // datatable
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
