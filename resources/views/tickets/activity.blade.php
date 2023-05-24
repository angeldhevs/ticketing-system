<div id="ticket-activity">
  @if ($ticket_activities->count() > 0)
  <div class="row p-1">
    <div class="form-group col-sm-12 text-muted">
      <h6>
        <i class="fa fa-history"></i>
        History
      </h6>
        <ul class="list-group">
        @foreach ($ticket_activities as $activity)
        @php($status = $activity->status)
          <li class="list-group-item list-group-item-{{ $status_context[$status->id - 1] }}">
            <div class="d-flex w-100 justify-content-between align-items-center">
              <h6 class="mb-1">
                <strong>
                  @switch($status->name)
                  @case("New")
                    Ticket added to system.
                    @break
                    @case("Open")
                      Ticket opened.
                      @break
                    @case("In Progress")
                      Ticket is in progress.
                      @break
                    @case("Needs More Info")
                      Ticket needs more information.
                      @break
                    @case("Resolved")
                      Ticket marked as resolved.
                      @break
                    @case("Closed")
                      Ticket marked as closed.
                      @break
                    @default
                  @endswitch
                </strong>
              </h6>
              <span class="badge badge-{{ $status_context[$status->id - 1] }}">{{ $status->name }}</span>
          </div>
          <div class="d-flex w-100 justify-content-between align-items-center">
            <span class="text-muted">{{ $activity->remarks }}</span>
            <span class="pull-right">{{ $activity->created_at->diffForHumans() }}</span>
          </div>
        </li>
        @endforeach
    </ul>
  </div>
  @else
  No history
  @endif
</div>
