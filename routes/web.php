<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', 'DashboardController@index');

Route::namespace('Manage')->prefix('manage')->name('manage.')->group(function() {
  Route::resource('users', 'UsersController');
  Route::resource('roles', 'RolesController');
});

Route::resource('tickets', 'TicketsController');
Route::resource('reports', 'Reports\ReportController');
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::post('/webhook/data/inboundemail','TicketsController@inboundEmail');



