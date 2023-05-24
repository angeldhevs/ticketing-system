<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketSummary extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $today = Carbon::today()->subDays(3)->format('Y-m-d');
        $new = TicketStatus::where('name', 'New')->first();
        $closed = TicketStatus::where('name', 'Closed')->first();

        return [
            'tickets' => [
                'new' => count($this->whereDate('created_at', $today)->where('current_status_id', '=', $new->id)->get()),
                'closed' => count($this->whereDate('updated_at', $today)->where('current_status_id', '=', $closed->id)->get()),
                'total' => count($this->all())
            ]
        ];
    }
}
