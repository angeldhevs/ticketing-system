<?php
use App\Broadcasting\PublicChannel;
use Illuminate\Broadcasting\PrivateChannel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function($user, $id) {
  return $user->id === (int)$id;
});

Broadcast::channel('Ticket', function($user) {
  return true;
});
