<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket\Ticket;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Tickets\CreateTicketRequest;
use App\Http\Requests\Tickets\UpdateTicketRequest;
use App\Http\Requests\Tickets\AssignTicketRequest;
use App\Http\Requests\Tickets\UpdateTicketStatusRequest;
use App\Http\Resources\Ticket\Ticket as TicketResource;

class TicketsController extends ApiController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = $this->user();
    $tickets = $user->hasRole('agent') && false ?
      Ticket::where('assignee_id', $user->id)->get() : Ticket::all();

    return TicketResource::collection($tickets);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\Tickets\CreateTicketRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateTicketRequest $request)
  {
    $ticket = $request->persist(new Ticket());
    return TicketResource::make($ticket);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Ticket\Ticket $ticket
   * @return \Illuminate\Http\Response
   */
  public function show(Ticket $ticket)
  {
    return TicketResource::make($ticket);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Tickets\UpdateTicketRequest  $request
   * @param  \App\Models\Ticket\Ticket $ticket
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateTicketRequest $request, Ticket $ticket)
  {
    $ticket = $request->persist($ticket);
    return TicketResource::make($ticket);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Tickets\UpdateTicketStatusRequest  $request
   * @param  \App\Models\Ticket\Ticket $ticket
   * @return \Illuminate\Http\Response
   */
  public function statusUpdate(UpdateTicketStatusRequest $request, Ticket $ticket)
  {
    $ticket = $request->persist($ticket);
    return TicketResource::make($ticket);
  }

    /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Tickets\AssignTicketRequest  $request
   * @param  \App\Models\Ticket\Ticket $ticket
   * @return \Illuminate\Http\Response
   */
   public function assign(AssignTicketRequest $request, Ticket $ticket)
   {
     $ticket = $request->persist($ticket);
     return TicketResource::make($ticket);
   }
}
