
window._ = require('lodash');
import Echo from 'laravel-echo';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.$.Datatable = require('datatables.net');
    window.moment = require('moment');
    window.mustache = require('mustache');
    window.TinyMCE = require('tinymce');
    window.Pusher = require('pusher-js');
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: true
    });

    require('jquery-confirm');
    require('jquery-validation');

    require('bootstrap');
    require('bootstrap-daterangepicker');
    require('bootstrap-select');

    require('datatables');
    require('datatables.net-bs4');
    require('datatables.net-plugins/sorting/datetime-moment');

    require('toastr');
    require('gridstack');
    require('chart.js');

    require('tinymce/jquery.tinymce');
    require('tinymce/themes/silver');
    require('tinymce/plugins/paste');
    require('tinymce/plugins/advlist');
    require('tinymce/plugins/autolink');
    require('tinymce/plugins/lists');
    require('tinymce/plugins/link');
    require('tinymce/plugins/image');
    require('tinymce/plugins/charmap');
    require('tinymce/plugins/print');
    require('tinymce/plugins/preview');
    require('tinymce/plugins/anchor');
    require('tinymce/plugins/textcolor');
    require('tinymce/plugins/searchreplace');
    require('tinymce/plugins/visualblocks');
    require('tinymce/plugins/code');
    require('tinymce/plugins/fullscreen');
    require('tinymce/plugins/insertdatetime');
    require('tinymce/plugins/media');
    require('tinymce/plugins/table');
    require('tinymce/plugins/contextmenu');
    require('tinymce/plugins/code');
    require('tinymce/plugins/help');
    require('tinymce/plugins/wordcount');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let csrf = document.head.querySelector('meta[name="csrf-token"]');
if (csrf) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let api = document.head.querySelector('meta[name="api-token"]');
if (api) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + api.content;
}
