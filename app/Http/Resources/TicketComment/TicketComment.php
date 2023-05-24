<?php

namespace App\Http\Resources\TicketComment;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketComment extends JsonResource
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
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'comment' => $this->comment,
            'parent_comment_id' => $this->parent_comment_id ?? null,
            'commenter' => [
                'id' => $this->commenter->id,
                'name' => $this->commenter->name,
            ],
            'replies' => TicketComment::collection($this->children)
        ];
    }
}
