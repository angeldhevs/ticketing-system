<?php

namespace App\Models\Ticket;

use App\Models\Ticket\TicketActivity;
use App\Models\ModelBase;
use App\Models\Ticket\TicketStatusFlow;

/**
 * Represents a possible status of a ticket in its lifetime.
 */
class TicketStatus extends ModelBase
{
    protected $table = 'ticket_status';
    protected $fillable = [ 'name', 'description' ];

    /**
     * Returns an array of status that is mapped as the next status.
     */
    public function next() {
        return $this->belongsToMany(self::class, 'ticket_status_flow', 'from_status_id', 'to_status_id')
                    ->using(TicketStatusFlow::class)
                    ->withTimestamps();
    }

    /**
     * Returns an array of status that is mapped as the previous status.
     */
    public function previous() {
        return $this->belongsToMany(self::class, 'ticket_status_flow', 'to_status_id', 'from_status_id')
                    ->using(TicketStatusFlow::class)
                    ->withTimestamps();
    }

    /**
     * The collection of tickets having the current status.
     */
    public function tickets() {
        return $this->hasMany(Ticket::class, 'status_id', 'id');
    }

    /**
     * Returns true if the current status is next to the specified status.. 
     */
    public function isNextTo(TicketStatus $status) {
        $next = $status->next;
        
        if($next === null || $next->count() === 0) {
            return false;
        }

        $status_ids = $next->pluck('id')->all();
        return in_array($this->id, $status_ids);
    }
}
