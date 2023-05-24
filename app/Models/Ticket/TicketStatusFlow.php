<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Represents the flow or transition of one ticket status to another.
 */
class TicketStatusFlow extends Pivot
{
    public $table = 'ticket_status_flow';

    protected $fillable = [
        'from_status_id',
        'to_status_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The source ticket status.
     */
    public function from_status() {
        return $this->belongsTo(TicketStatus::class, 'from_status_id', 'id');
    }

    /**
     * The destination ticket status.
     */
    public function to_status() {
        return $this->belongsTo(TicketStatus::class, 'to_status_id', 'id');
    }
}
