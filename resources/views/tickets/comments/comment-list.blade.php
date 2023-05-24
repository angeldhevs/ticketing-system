<div class="comment-list list-group list-group-flush" 
  @if(isset($parent_comment_id) && $parent_comment_id !== null) 
  data-parent-comment-id="{{ $parent_comment_id }}"
  @endisset>

  @include('tickets.comments.comment-item', [ 
    'ticket_id' => $ticket_id,
    'top_level' => $top_level
  ])

  @if(isset($comments) && $comments !== null)
  @foreach ($comments as $comment)
    @include('tickets.comments.comment-item', [ 
      'ticket_id' => $ticket_id,
      'comment' => $comment
    ])
  @endforeach
  @endif

</div>