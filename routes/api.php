<?php

use Illuminate\Http\Request;
use App\Http\Resources\User\User as UserResource;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketComment;
use Illuminate\Notifications\DatabaseNotification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::model('ticket', Ticket::class);
Route::model('comment', TicketComment::class);
Route::model('notification', DatabaseNotification::class);
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

// Route::fallback(function(Request $request) {
//     return response()->json([
//         'message' => 'The resource you are looking for does not exist in the server.'
//     ], 404);
// });

Route::middleware('auth:api')->get('user', function (Request $request) {
    return UserResource::make($request->user());
});

Route::apiResource('users', 'UsersController');
Route::get('/users/{user}/token/refresh', 'UserTokenController@refresh');

Route::get('/notifications', 'NotificationController@index')->name('notifications');
Route::post('/notification/{notification}/read', 'NotificationController@read')->name('notification.read');


Route::apiResource('roles', 'RolesController');
Route::apiResource('tickets', 'TicketsController');
Route::patch('tickets/{ticket}/assign', 'TicketsController@assign')->name('tickets.assign');
Route::patch('tickets/{ticket}/update-status', 'TicketsController@statusUpdate')->name('tickets.update.status');

Route::prefix('ticket')->name('ticket-')->group(function() {
    Route::apiResource('status', 'TicketStatusController');
    Route::apiResource('severities', 'TicketSeveritiesController');

    Route::get('{ticket}/activities', 'TicketActivitiesController@index')->name('activities.index');

    Route::name('comments.')->group(function() {
        Route::get('{ticket}/comments', 'TicketCommentsController@index')->name('index');
        Route::post('{ticket}/comments', 'TicketCommentsController@store')->name('store');
        Route::match(['patch', 'put'], '{ticket}/comments/{comment}', 'TicketCommentsController@update')->name('update');
        Route::delete('{ticket}/comments/{comment}', 'TicketCommentsController@destroy')->name('destroy');
    });
});

Route::prefix('dashboard')->name('dashboard.')->group(function() {
    Route::get('tickets-per-status', 'DashboardController@getTicketsPerStatus')->name('tickets-per-status');
    Route::get('tickets-per-severity', 'DashboardController@getTicketsPerSeverity')->name('tickets-per-severity');
    Route::get('recent-ticket-updates', 'DashboardController@getRecentTicketUpdates')->name('recent-ticket-updates');
    Route::get('new-vs-closed-tickets', 'DashboardController@getNewVsClosedTickets')->name('new-vs-closed-tickets');
});
