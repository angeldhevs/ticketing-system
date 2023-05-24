<?php

namespace App\Http\Resources\TicketActivity;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketActivity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status->name,
            'assignee' => $this->assignee ? $this->assignee->name : null,
            'reporter' => $this->reporter ? $this->reporter->name : null,
            'remarks' => $this->remarks,
            'date_executed' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
