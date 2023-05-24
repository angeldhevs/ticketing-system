"use strict";

$(function() {
    let options = {
        datatable: {
            columns: [
                {
                    name: 'Role',
                    searchable: true,
                    width: 600,
                },
                {
                    name: 'Action',
                    searchable: true,
                    width: 50,
                    orderable: false
                },
            ],
            scrollY: 400,
            scrollCollapse: true,
            pagingType: 'full_numbers',
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
                info: '_START_ to _END_ of _TOTAL_',
                paginate: {
                    first: '«',
                    previous: '‹',
                    next: '›',
                    last: '»'
                }
            }
        },
        initialHtmlHeight: 712
    }

    //Cache DOM reference to avoid jquery to requery the DOM for the element (for efficiency).
    let $dtWrapper = $('.dt-wrapper');
    let $dtTopBar = $dtWrapper.find('.dt-top-bar');
    let $dtBotBar = $dtWrapper.find('.dt-bot-bar');
    let $dtTable = $dtWrapper.find('table');

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
        let $scroller = $dtTable.closest('.dataTables_scrollBody');
        let newHeight = ($scroller.innerHeight() / options.initialHtmlHeight) * $('html').height();
        newHeight = Math.round(newHeight / 100) * 100;
        $scroller
            .css('min-height', options.datatable.scrollY)
            .css('max-height', options.datatable.scrollY)
            .css('overflow-y', 'scroll');
    }

    function filterTable(e) {
        let $input = $(e.currentTarget);
        $dtTable.DataTable().search($input.val()).draw();
    }

    initialize();
});
