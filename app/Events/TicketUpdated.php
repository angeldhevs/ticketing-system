<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Ticket\Ticket;
use App\Http\Resources\Ticket\Ticket as TicketResource;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TicketUpdated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  private $ticket;
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(Ticket $ticket)
  {
    $this->ticket = $ticket;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new Channel('Ticket');
  }

  public function broadcastAs()
  {
    return 'Ticket.Updated';
  }

  public function broadcastWith()
  {
    return [
      'message' => 'Ticket #' . $this->ticket->ticket_number . ' has been updated.',
      'data' => TicketResource::make($this->ticket)
    ];
  }
}
