<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Ticket;
use App\Models\ModelBase;

/**
 * Represents the severity of the ticket
 */
class TicketSeverity extends ModelBase
{
    protected $fillable = [ 'name' ];

    /**
     * The tickets with the current severity.
     */
    public function tickets() {
        return $this->hasMany(Ticket::class, 'severity_id', 'id');
    }
}
