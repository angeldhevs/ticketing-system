<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manage\User;
use App\Http\Resources\Notification\Notification as NotificationResource;
use Illuminate\Notifications\DatabaseNotification;
use Faker\Provider\Uuid;

class NotificationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unreadOnly = $request->query('unread');
        $notifications = $unreadOnly == true ? 
            $this->user()->unreadNotifications : 
            $this->user()->notifications;
 
        return NotificationResource::collection($notifications);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return response()->json(null, 204);
        //
    }
}
