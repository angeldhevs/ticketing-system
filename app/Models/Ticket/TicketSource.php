<?php

namespace App\Models\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\ModelBase;

/**
 * Represents a ticket source.
 */
class TicketSource extends ModelBase
{
    protected $fillable = [ 'name' ];

    /**
     * The tickets with the current source.
     */
    public function tickets() {
        return $this->hasMany(Ticket::class, 'source_id', 'id');
    }
}
