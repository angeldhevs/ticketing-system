<?php

namespace App\Models\Ticket;

use App\Models\ModelBase;
use App\Models\Ticket\TicketSource;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketSeverity;
use App\Models\Ticket\TicketActivity;
use App\Models\Manage\User;
use Carbon\Carbon;

/**
 * Represents the ticket to be processed by an agent.
 */
class Ticket extends ModelBase
{
    protected $fillable = [
        'ticket_number',
        'ticket_title',
        'client_name',
        'client_email',
        'ticket_details',
        'source_id',
        'severity_id',
        'status_id',
        'reporter_id',
        'assignee_id'
    ];

    /**
     * The source of the ticket - either from email or created.
     */
    public function source()
    {
        return $this->belongsTo(TicketSource::class);
    }

    /**
     * The severity of the ticket - either low, medium, high, critical, or unclassified.
     */
    public function severity()
    {
        return $this->belongsTo(TicketSeverity::class);
    }

    /**
     * The current status of the ticket.
     */
    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id', 'id');
    }

    /**
     * The user who reports/assigns the ticket to an agent.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id', 'id');
    }

    /**
     * The user to whom this ticket is assigned to.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }

    /**
     * The progress of the ticket. This strictly points to the ticket status changes and not the changes on the ticket (e.g. change title).
     */
    public function activities()
    {
        return $this->hasMany(TicketActivity::class)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * The comments associated with the current ticket.
     */
    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    /**
     * Returns the latest progress of the ticket.
     */
    public function current()
    {
        return $this->activities->first();
    }

    /**
     * Returns if the current ticket has any progress recorded.
     */
    public function hasProgress()
    {
        return $this->current() !== null;
    }

    /**
     * Returns true if the ticket is closed; otherwise false.
     */
    public function isClosed()
    {
        return strcasecmp($this->current()->status->name, "closed") == 0;
    }

    /**
     * Adds a new comment to the current ticket.
     * 
     * @param string $comment
     * @param int $commenter_id
     * @param int $parent_comment_id
     */
    public function addComment(string $comment, int $commenter_id, ?int $parent_comment_id = null)
    {
        //Assemble the data.
        $data = [
            'commenter_id' => $commenter_id,
            'comment' => $comment
        ];

        if ($parent_comment_id !== null) {
            $parent_comment = $this->comments
                ->where('id', $parent_comment_id)
                ->first();

            //Add as new comment if not found.
            if ($parent_comment === null) {
                return $this->comments()->create($data);
                //...else set as reply to the parent comment.
            } else {
                $parent_comment->reply($comment, $commenter_id);
            }
        } else {
            //Add as new comment if no parent comment id specified.
            return $this->comments()->create($data);
        }
    }

    public function hasBeenAssigned()
    {
        return $this->getOriginal('assignee_id') !== $this->assignee_id;
    }

    public function statusHasBeenUpdated() 
    {
        return $this->getOriginal('status_id') !== $this->status_id;
    }

    public function hasBeenClosed() 
    {
        return $this->status->name === 'Closed';
    }

    public function countClosed()
    {
        return $this->current()->count();
    }
}
