<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Ticket\TicketStatus;

class TicketsPerDate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $new = TicketStatus::where('name', 'New')->first();
        $closed = TicketStatus::where('name', 'Closed')->first();

        $r = $this
            ->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->reduce(function($result, $group) use ($new, $closed) {
                $key = $group->keyBy('created_at');
                $val = collect([
                    'new' => count($group->where('status_id', $new->id)),
                    'closed' => count($group->where('status_id', $closed->id))
                ]);
                return $result->put($key, $val);
            }, collect());

        return $r;
    }
}
