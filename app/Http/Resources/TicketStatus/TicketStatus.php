<?php

namespace App\Http\Resources\TicketStatus;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Ticket\TicketStatus as TicketStatusModel;

class TicketStatus extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this-> id,
            'name' => $this->name,
            'description' => $this->description
        ];

        if ( ($include = $request->query('include')) != null ) {
            $includes = explode(',', $include);

            if(in_array('prev', $includes)) {
                $response += [ 'prev' => $this->previous->map($this->getStatusBasic())]; 
            }

            if(in_array('next', $includes)) {
                $response += [  'next' => $this->next->map($this->getStatusBasic())]; 
            }

            if(in_array('tickets', $includes)) {
                $response += [  'tickets' => $this->tickets ]; 
            }
        }

        return $response;
    }

    private function getStatusBasic(): callable 
    {
        return function(TicketStatusModel $status) {
            return $status->only(['id', 'name']);
        };
    }
}
