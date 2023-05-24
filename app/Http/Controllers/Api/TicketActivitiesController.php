<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket\Ticket;
use App\Http\Resources\TicketActivity\TicketActivity as TicketActivityResource;

class TicketActivitiesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Ticket\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function index(Ticket $ticket) {
        return TicketActivityResource::collection($ticket->activities);
    }
}
