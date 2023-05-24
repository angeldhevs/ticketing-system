<?php

namespace App\Models\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketStatus;
use App\Models\Manage\User;
use App\Models\ModelBase;

/**
 * Represents a progress of a ticket.
 */
class TicketActivity extends ModelBase
{
    public $incrementing = true;

    protected $fillable = [
        'ticket_id',
        'status_id',
        'assignee_id',
        'reporter_id',
        'remarks',
    ];

    /**
     * The ticket where this progress is associated to.
     */
    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    /**
     * The ticket status for the current progress.
     */
    public function status() {
        return $this->belongsTo(TicketStatus::class, 'status_id', 'id');
    }

    /**
     * The user (presumably with a role of agent) to whose the ticket is assigned to.
     */
    public function assignee() {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }

    /**
     * The user (presumably with a role of admin/team leader) to assigned the ticket to the agent.
     */
    public function reporter() {
        return $this->belongsTo(User::class, 'reporter_id', 'id');
    }

    /**
     * Creates a new instance of ticket progress from the current record.
     */
    public function createNext(array $attributes) {
        return static::query()->create([
            'ticket_id'      => $this->ticket_id,
            'status_id'      => $attributes['status_id'],
            'assignee_id'    => $attributes['assignee_id']  ?? $this->assignee_id,
            'reporter_id'    => $attributes['reporter_id']  ?? $this->reporter_id,
            'remarks'        => $attributes['remarks']      ?? '-None-'
        ]);
    }
}
