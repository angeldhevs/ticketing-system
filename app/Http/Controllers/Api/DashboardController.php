<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Dashboard\TicketsPerStatus;
use App\Http\Resources\Dashboard\TicketsPerSeverity;
use App\Http\Resources\Dashboard\NewVsClosedTickets;
use App\Http\Resources\Ticket\Ticket as TicketResource;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketSeverity;
use App\Models\Ticket\Ticket;
use App\Http\Requests\Dashboard\DateRangeRequest;
use App\Models\Ticket\TicketActivity;

class DashboardController extends ApiController
{
    public function getTicketsPerStatus() {
        return TicketsPerStatus::collection(TicketStatus::all());
    }

    public function getTicketsPerSeverity() {
        return TicketsPerSeverity::collection(TicketSeverity::all());
    }

    public function getRecentTicketUpdates() {
        return TicketResource::collection(Ticket::orderBy('updated_at', 'desc')->take(10)->get());
    }

    public function getNewVsClosedTickets(DateRangeRequest $request) {
        return NewVsClosedTickets::make(TicketActivity::select(['ticket_id', 'status_id', 'created_at']));
    }
}
