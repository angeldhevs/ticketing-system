<div class="comments-section form-group text-muted">
  <h6><i class="fa fa-comments"></i> Comments</h6>
  @include('tickets.comments.comment-list', [ 
    'ticket_id' => $ticket_id,
    'comments' => $ticket_comments, 
    'top_level' => true 
  ])
</div>
