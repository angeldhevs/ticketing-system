<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
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
            'data' => $this->data,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'read_at' => $this->read_at != null ? $this->read_at->format('Y-m-d H:i:s') : null,
            'read_url' => route('api.notification.read', [ 'id' => $this->id ])
        ];
    }
}
