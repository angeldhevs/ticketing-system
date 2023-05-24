<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket\TicketStatus;
use App\Http\Resources\TicketStatus\TicketStatus as TicketStatusResource;
use App\Http\Requests\TicketStatus\StoreTicketStatusRequest;
use App\Http\Requests\TicketStatus\UpdateTicketStatusRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class TicketStatusController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $statuses = 
            $request->has('after') ? TicketStatus::where('name', '=', $request->query('after'))->first()->next :
            ($request->has('first') && $request->input('first') ? TicketStatus::doesntHave('previous')->get() :
            TicketStatus::all());

        return TicketStatusResource::collection(($statuses)->sortBy('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TicketStatus\StoreTicketStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketStatusRequest $request) {
        $status = $request->persist(new TicketStatus());
        return TicketStatusResource::make($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket\TicketStatus $status
     * @return \Illuminate\Http\Response
     */
    public function show(TicketStatus $status) {
        return TicketStatusResource::make($status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TicketStatus\UpdateTicketStatusRequest  $request
     * @param  \App\Models\Ticket\TicketStatus $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketStatusRequest $request, TicketStatus $status) {
        $status = $request->persist($status);
        return TicketStatusResource::make($status);
    }
}
