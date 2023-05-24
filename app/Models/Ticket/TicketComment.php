<?php

namespace App\Models\Ticket;

use App\Models\ModelBase;
use App\Models\Core\Ticket;
use App\Models\Manage\User;

/**
 * The comments related to a ticket.
 */
class TicketComment extends ModelBase
{
    protected $fillable = [
        'comment',
        'ticket_id',
        'parent_comment_id',
        'commenter_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The ticket where this comment is associated to.
     */
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * The parent comment.
     */
    public function parent() {
        return $this->belongsTo(TicketComment::class, 'parent_comment_id');
    }

    /**
     * The user who adds the comment.
     */
    public function commenter() {
        return $this->belongsTo(User::class, 'commenter_id', 'id');
    }

    /**
     * The related children comments.
     */
    public function children() {
        return $this->hasMany(TicketComment::class, 'id', 'parent_comment_id');
    }

    /**
     * Adds a new reply to the current comment.
     */
    public function reply(string $comment, ?int $commenter_id = null) {
        return static::query()->create([
            'ticket_id' => $this->ticket_id,
            'parent_comment_id' => $this->id,
            'commenter_id' => $commenter_id ?? $this->commenter_id,
            'comment' => $comment
        ]);
    }

    /**
     * Updates the current comment.
     */
    public function update(array $attributes = [], array $options = []) {
        return $this->fill([
            'comment' => $attributes['comment'] ?? $this->comment
        ])->save();
    }
}
