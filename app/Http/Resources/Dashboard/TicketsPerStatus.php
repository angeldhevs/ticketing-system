<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketsPerStatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tickets = $this->tickets();

        if($request->from) {
            $tickets = $tickets->whereDate('updated_at', '>=', $request->from);
        }

        if($request->to) {
            $tickets = $tickets->whereDate('updated_at', '<=', $request->to);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'ticket_count' => count($tickets->get())
        ];
    }
}
