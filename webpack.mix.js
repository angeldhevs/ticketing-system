const mix = require('laravel-mix');

mix.disableNotifications();
/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for the application as well as bundling up all the JS files.
|
*/
mix.setPublicPath('public');

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/assets/fonts/font-awesome');
mix.copy('node_modules/tinymce/skins', 'public/js/skins');

//App.css
mix
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/modules/ticket/ticket.scss', 'public/css/modules')
  .sass('resources/sass/modules/auth/auth.scss', 'public/css/modules')
  .sass('resources/sass/modules/dashboard/dashboard.scss', 'public/css/modules')

mix.js('resources/js/lib.js', 'public/js');

//Components
mix.js([
  'resources/js/components/dialog-box.js',
  'resources/js/components/spinner.js',
  'resources/js/components/navigation.js',
], 'public/js/components.js');

//Utilities
mix.js([
  'resources/js/utils/extension-methods.js',
  'resources/js/utils/form-validation.js',
], 'public/js/utils.js');

//Ticket Module
mix.js([
  'resources/js/tickets/index.js',
], 'public/js/modules/ticket.js');

//Ticket Modal
mix.js([
  'resources/js/tickets/modal.js',
], 'public/js/modules/ticket/modal.js');

//Manage User Module
mix.js([
  'resources/js/admin/manage/users/index.js',
  'resources/js/admin/manage/users/form.js',
], 'public/js/modules/manage/users.js');

//Manage Role Module
mix.js([
  'resources/js/admin/manage/roles/index.js',
  'resources/js/admin/manage/roles/create.js',
], 'public/js/modules/manage/roles.js');

//Reports Module
mix.js([
  'resources/js/reports/index.js',
], 'public/js/modules/reports.js');


//Dashboard Module
mix.js([
  'resources/js/dashboard/charts/tickets-per-status.js',
  'resources/js/dashboard/charts/tickets-per-severity.js',
  'resources/js/dashboard/charts/new-vs-closed-tickets.js',
], 'public/js/modules/dashboard.js');

//Notification Module
mix.js([
  'resources/js/notification/notification-manager.js',
], 'public/js/modules/notification.js');
