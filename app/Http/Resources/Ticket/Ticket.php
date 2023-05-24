<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TicketSource\TicketSource;
use App\Http\Resources\TicketSeverity\TicketSeverity;
use App\Http\Resources\TicketStatus\TicketStatus;
use App\Http\Resources\User\User;

class Ticket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result =  [
            'data' => [
                'id' => $this->id,
                'ticket_number' => $this->ticket_number,
                'title' => $this->ticket_title,
                'source' => TicketSource::make($this->source),
                'severity' => TicketSeverity::make($this->severity),
                'status' => TicketStatus::make($this->status),
                'reporter' => $this->reporter !== null ? User::make($this->reporter) : null,
                'assignee' => $this->assignee !== null ? User::make($this->assignee) : null,
                'details' => $this->ticket_details,
                'client' => [
                    'name' => $this->client_name,
                    'email' =>$this->client_email
                ],
                'date_created' => $this->created_at->format('Y-m-d H:i:s'),
                'date_updated' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
            'links' => [
                'self' => route('api.tickets.show', [ 'id' => $this->id ]),
                'update' => route('api.tickets.update', [ 'id' => $this->id ]),
                'assign' => route('api.tickets.assign', [ 'id' => $this->id ]),
                'status_update' => route('api.tickets.update.status', [ 'id' => $this->id ]),
                'comments' => route('api.ticket-comments.index', [ 'id' => $this->id ]),
                'activities' => route('api.ticket-activities.index', [ 'id' => $this->id ])
            ]
        ];

        return $result;
    }
}
