@php
$has_comment = isset($comment) && $comment !== null;
$user = $has_comment ? $comment->commenter : Auth::user();
@endphp

<div 
  @if(!$top_level) style="display: none;" @endif
  class="comment-box list-group-item p-2 {{ $has_comment && isset($comment->comment) ? 'display-mode' : 'edit-mode' }}" 
  data-id="{{ $has_comment && isset($comment->id) ? $comment->id : null }}" 
  data-commneter-id="{{ $user->id }}">
  <div class="comment-header d-flex w-100 justify-content-between mb-1">
    <a href="{{ route('manage.users.show', [ 'id' => $user->id ]) }}" class="commenter">
      <i class="fa fa-2x fa-user-circle"></i>
      <strong>{{ $user->name }}</strong>
    </a>
    <small class="comment-timestamp ml-auto">{{ $has_comment ? $comment->created_at->diffForHumans() : '' }}</small>
  </div>
  <p class="mb-1 text-muted comment">
    {{ $has_comment ? trim($comment->comment) : '' }}
  </p>
  <textarea 
    class="mb-1 text-muted comment" 
    placeholder="Add comment..." 
    maxlength="500" 
    rows="3"
    data-url="{{ route('api.ticket.comments.store', [ 'id' => $ticket_id ]) }}">{{ $has_comment ? trim($comment->comment) : null }}</textarea>
  <div class="comment-actions w-100 d-flex flex-row justify-content-end">
    @if($has_comment)
      <a href="#reply" data-action="reply" data-url="{{ route('api.ticket.comments.store', [ 'id' => $ticket_id ]) }}" data-toggle="tooltip" data-placement="top" title="Reply to comment">
        <i class="fa fa-reply"></i>
      </a>
      @if($user->id === Auth::user()->id)
      <a href="#edit"  data-action="edit" data-url= "{{ route('api.ticket.comments.update', [ 'id' => $comment->id ]) }}" data-toggle="tooltip" data-placement="top" title="Edit comment">
        <i class="fa fa-edit"></i>
      </a>
      <a href="#delete" data-action="delete" data-url= "{{ route('api.ticket.comments.destroy', [ 'id' => $comment->id ]) }}" data-toggle="tooltip" data-placement="top" title="Delete comment">
        <i class="fa fa-times"></i>
      </a>
      @endif
    @endif
  </div>
  @if(($has_comment && $comment->children->count() > 0) || $top_level)
    @include('tickets.comments.comment-list', [ 
      'ticket_id' => $ticket_id,
      'parent_comment_id' => $has_comment ? $comment->id : null,
      'comments' => $has_comment ? $comment->children : null,
      'top_level'  => false
    ])
  @endif
</div>