<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketComment;
use App\Http\Requests\TicketComments\StoreTicketCommentRequest;
use App\Http\Requests\TicketComments\UpdateTicketCommentRequest;
use App\Http\Resources\TicketComment\TicketComment as TicketCommentResource;

class TicketCommentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Ticket\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function index(Ticket $ticket) {
        return TicketCommentResource::collection($ticket->comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Ticket\Ticket $ticket
     * @param  \App\Http\Requests\TicketComments\StoreTicketCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ticket $ticket, StoreTicketCommentRequest $request) {
        $comment = $ticket->addComment($request->comment, $this->user()->id, $request->parent_comment_id);
        return TicketCommentResource::make($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Ticket\Ticket $ticket
     * @param \App\Models\Ticket\TicketComment $comment
     * @param  \App\Http\Requests\TicketComments\UpdateTicketCommentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Ticket $ticket, TicketComment $comment, UpdateTicketCommentRequest $request) {
        $request->persist($comment);
        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param \App\Models\Ticket\Ticket $ticket
     * @param \App\Models\Ticket\TicketComment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket, TicketComment $comment) {
        $comment->delete();
        return response(null, 204);
    }
}
