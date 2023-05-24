<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Ticket\TicketStatus;
use Carbon\CarbonPeriod;

class NewVsClosedTickets extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $new = TicketStatus::where('name', 'new')->first();
        $closed = TicketStatus::where('name', 'closed')->first();

        return $this
            ->whereIn('status_id', array($new->id, $closed->id))
            ->when($request->from, function($q, $d) {
                return $q->where('created_at', '>=', $d);
            })
            ->when($request->to, function($q, $d) {
                return $q->where('created_at', '<=', $d);
            })
            ->get(['ticket_id', 'status_id', 'created_at'])
            ->sortBy('created_at')
            ->groupBy(function($p) {
                return $p->created_at->format('Y-m-d');
            })
            ->reduce(function($result, $group) use($new, $closed) {
                array_push($result, [
                    'date' => $group->first()->created_at->format('Y-m-d'),
                    'new' => count($group->where('status_id', $new->id)->toArray()),
                    'closed' => count($group->where('status_id', $closed->id)->toArray()),
                ]);
                return $result;
            }, array());
    }
}
