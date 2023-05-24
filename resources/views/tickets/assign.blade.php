<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalAssignTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form class="modal-dialog modal-lg" role="document" method="PUT">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ticket_id" name="ticket_id" value="{{$ticket->id}}">
        @if($ticket->current()->assignee)
          <input type="hidden" id="assignee_id" name="assignee_id" value="{{$ticket->current()->assignee->id}}">
        @endif
        @if($ticket->current()->reporter)
          <input type="hidden" id="reporter_id" name="reporter_id" value="{{$ticket->current()->reporter->id}}">
        @endif
        <div class="row p-1">
          <div class="col col-sm-12 col-md-6">
            <span class="card-text">
              <strong>Source : </strong>
              {{ $ticket->source->name }}
            </span>
          </div>
          <div class="col col-sm-12 col-md-6">
            <span class="card-text">
              <strong>Created : </strong>
              {{ $ticket->created_at->diffForHumans() }}
            </span>
          </div>
        </div>
        <div class="row p-1">
          <div class="col col-sm-12 col-md-6">
            <span class="card-text">
              <strong>Reporter : </strong>
              @if($ticket->current()->reporter)
                {{ $ticket->current()->reporter->name }}
              @else
                UNASSIGNED
              @endif
            </span>
          </div>
          <div class="col col-sm-12 col-md-6">
              <span class="card-text">
                <strong>Assignee : </strong>
                @if($ticket->current()->assignee)
                  {{ $ticket->current()->assignee->name }}
                @else
                  <select id="agent" class="form">
                  @foreach($agents as $agent)
                      <option value="{{$agent['id']}}">{{$agent['name']}}</option>
                    @endforeach
                </select>
                @endif
              </span>
          </div>
        </div>
        <div class="row p-1">
          <div class="col col-sm-12 col-md-6">
              <span class="card-text">
                <strong>Severity : </strong>
                  <select id="severity_assigned" class="form">
                  @foreach($severities as $severity)
                      <option value="{{$severity->id}}">{{$severity->name}}</option>
                    @endforeach
                </select>
              </span>
          </div>
          <div class="col col-sm-12 col-md-6">
            <span class="card-text">
              <strong>Status : </strong>
                <select id="status_assigned" class="form">
                  @foreach($ticket_status as $ticket_stats)
                    <option value="{{$ticket_stats->id}}">{{$ticket_stats->name}}</option>
                  @endforeach
                </select>
            </span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnAssignTicket">Assign</button>
      </div>
    </div>
  </form>
</div>
</div>
