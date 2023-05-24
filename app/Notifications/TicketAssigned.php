<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Ticket\Ticket;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TicketAssigned extends Notification implements ShouldQueue
{
  use Queueable;

  private $ticket;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Ticket $ticket)
  {
    $this->ticket = $ticket;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['broadcast', 'database', 'mail'];
  }

  public function toMail($notifiable)
  {
    $url = route('tickets.index', ['id' => $this->ticket->id]);

    return (new MailMessage)
      ->from('noreply@ticketing-system.com', 'Ticketing')
      ->subject('Ticket Assignment')
      ->greeting('Hello!')
      ->line('Ticket #' . $this->ticket->ticket_number . ' has been assigned to you!')
      ->action('View Ticket', $url);
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toBroadcast($notifiable)
  {
    return new BroadcastMessage($this->toDatabase($notifiable));
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toDatabase($notifiable)
  {
    return [
      'ticket_number' => $this->ticket->ticket_number,
      'ticket_id' => $this->ticket->id,
      'url' => route('tickets.index', ['id' => $this->ticket->id]),
      'resource_url' => route('api.tickets.show', ['id' => $this->ticket->id]),
      'message' => 'Ticket #' . $this->ticket->ticket_number . ' has been assigned to you.'
    ];
  }
}
