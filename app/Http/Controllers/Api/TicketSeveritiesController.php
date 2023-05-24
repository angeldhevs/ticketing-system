<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket\TicketSeverity;
use App\Http\Resources\TicketSeverity\TicketSeverity as TicketSeverityResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\TicketSeverities\StoreTicketSeverityRequest;

class TicketSeveritiesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $severities = TicketSeverity::all()->sortBy('id');
        return TicketSeverityResource::collection($severities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TicketSeverities\StoreTicketSeverityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketSeverityRequest $request) {
        $severity = $request->persist(new TicketSeverity());
        return response()->json($severity, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket\TicketSeverity $severity
     * @return \Illuminate\Http\Response
     */
    public function show(TicketSeverity $severity) {
        return TicketSeverityResource::make($severity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TicketSeverities\UpdateTicketSeverityRequest  $request
     * @param  \App\Models\Ticket\TicketSeverity $severity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketSeverityRequest $request, TicketSeverity $severity) {
        $severity = $request->persist($severity);
        return response()->json($severity, 200);
    }
}
