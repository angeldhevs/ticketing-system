<?php

namespace App\Observers;

use App\Models\Ticket\Ticket;
use Carbon\Carbon;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketSource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketClosed;
use App\Notifications\TicketAssigned;
use App\Models\Manage\User;
use App\Events\TicketCreated;
use App\Events\TicketUpdated;

class TicketObserver
{
  /**
   * Handle the ticket "creating" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function creating(Ticket $ticket)
  {
    $today = Carbon::today();
    $ticket->fill([
      'ticket_number' => sprintf($today->format('ymd') . '%03d', (Ticket::count()) + 1),
      'status_id' => TicketStatus::where('name', 'New')->first()->id,
      'source_id' => TicketSource::where('name', isset($ticket->assignee_id) && isset($ticket->reporter_id) ? 'Created' : 'Email')->first()->id,
      'severity_id' => $ticket->severity_id ?? TicketSeverity::where('name', 'unclassified')->first()->id
    ]);
  }

  /**
   * Handle the ticket "created" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function created(Ticket $ticket)
  {
    //Creates a new activity
    $ticket->activities()->create([
      'status_id'     => $ticket->status_id,
      'remarks'       => $ticket->severity->name === 'Email' ? 'Ticket created from email.' : 'Ticket created manually.',
    ]);

    //If there's an assignee and reporter set in the specified attributes,
    //update the status as open.
    if (!is_null($ticket->assignee)) {
      $status = $ticket->status->next->where('name', 'Open')->first();
      $ticket->update(['status_id' => $status->id]);
    }

    broadcast(new TicketCreated($ticket));
  }

  /**
   * Handle the ticket "updating" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function updating(Ticket $ticket)
  {

    $ticket
      ->current()
      ->createNext([
        'status_id'     => $ticket->status_id,
        'assignee_id'   => $ticket->assignee_id ?? null,
        'reporter_id'   => $ticket->reporter_id ?? null,
        'remarks'       => request()->remarks ?? '-None-',
      ]);
  }

  /**
   * Handle the ticket "updated" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function updated(Ticket $ticket)
  {
    if (true) { //Set to false if you are migrating/reseeding.

      if ($ticket->hasBeenAssigned()) {
        Notification::sendNow($ticket->assignee, new TicketAssigned($ticket));
      }

      if ($ticket->hasBeenClosed()) {
        $admins = User::whereHas('roles', function ($q) {
          $q->where('name', 'admin');
        })->get();

        Notification::sendNow($admins, new TicketClosed($ticket));
      }

      broadcast(new TicketUpdated($ticket));
    }
  }

  /**
   * Handle the ticket "deleted" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function deleted(Ticket $ticket)
  {
    //
  }

  /**
   * Handle the ticket "restored" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function restored(Ticket $ticket)
  {
    //
  }

  /**
   * Handle the ticket "force deleted" event.
   *
   * @param  \App\Models\Ticket\Ticket  $ticket
   * @return void
   */
  public function forceDeleted(TicketUser $ticket)
  {
    //
  }
}
