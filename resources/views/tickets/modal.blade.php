<div id="ticket-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ticketForm" aria-hidden="true" data-mode="create" data-create-url="{{ route('api.tickets.store') }}" data-resource-url="{{ route('api.tickets.index') }}">
  <form action="{{ route('api.tickets.store') }}" method="POST" class="modal-dialog modal-xl" role="document" >
    <input type="hidden" name="source_id" data-default-value="{{ $source_id ?? null }}" value="{{ $source_id ?? null }}" data-map-from="source.id" />
    <div class="modal-content">
      @include('components.spinner')

      <div class="modal-header pb-0">

        <div class="modal-top-bar w-100">
          <strong class="modal-title">
            <i class="fa fa-ticket-alt"></i>
            <span class="modal-title-text">
              New Ticket
            </span>
          </strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times"></i>
          </button>
        </div>

        <!-- Ticket title -->
        <div class="row w-100">
          <div class="form-group col col-xs-12 mb-0">
            <input id="ticket_title" type="text" class="form-control" name="ticket_title" placeholder="Ticket title"
              data-validation-required="Ticket title is required" data-disable-on="view,assign,status_update" data-map-from="title"
              tabindex="1" />
          </div>
        </div>

        <div class="row w-100">
          <div class="col-col-sm-6"></div>
        </div>

        <!-- OTHER FIELDS -->
        <div class="row w-100">

          <!-- TICKET DETAILS -->
          <div class="col col-xs-12 col-sm-4 detail-group">

            <!-- Status -->
            <div class="row form-group">
              <label for="status_id" class="col-xs-12 col-sm-2 col-form-label">Status</label>
              <div class="col-xs-12 col-sm-10 input-group">
                <div class="input-group-prepend prev-status">
                  <div class="input-group-text status-name">
                    <span class="font-italic">New</span>
                    <i class="fa fa-arrow-right pl-1"></i>
                  </div>
                </div>
                <select id="ticket_status" class="form-control" name="status_id" data-validation-required="Status is required"
                  data-disable-on="view,assign,create,update" data-options-url="{{ route('api.ticket-status.index')  }}"
                  data-option-text="name" data-option-value="id" data-map-from="status.id" data-default-value="1" tabindex="2">
                  <option value="" selected>Select status...</option>
                </select>
                <div class="input-group-append status-btns">
                  <button type="button" class="btn btn-sm btn-edit" data-mode="status_update">
                    <i class="fa fa-pen"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-save" data-mode="view" tabindex="3" >
                    <i class="fa fa-save"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Severity -->
            <div class="row form-group">
              <label for="severity_id" class="col-xs-12 col-sm-2 col-form-label">Severity</label>
              <div class="col-xs-12 col-sm-10">
                <select id="ticket_severity" class="form-control" name="severity_id" data-validation-required="Severity is required"
                  data-disable-on="view,assign,status_update" data-options-url="{{ route('api.ticket-severities.index')  }}"
                  data-option-text="name" data-option-value="id" data-map-from="severity.id" data-default-value="1" tabindex="4">
                  <option value="" selected>Select severity...</option>
                </select>
              </div>
            </div>

          </div>

          <!-- ASSIGNMENT DETAILS -->
          <div class="col col-xs-12 col-sm-4 detail-group">

            <!-- Reporter -->
            <div class="row form-group">
              <label for="reporter_id" class="col-xs-12 col-sm-2 col-form-label">Reporter</label>
              <div class="col-xs-12 col-sm-10">
                <input type="hidden" name="reporter_id" data-map-from="reporter.id" data-default-value="{{ $reporter_id }}" value="{{ $reporter_id }}" />
                <input id="reporter" type="text" placeholder="Not set" class="form-control" name="reporter_name" data-map-from="reporter.name" data-default-value="{{ $reporter_name }}" data-editable="false" value="{{ $reporter_name }}" />
              </div>
            </div>

            <!-- Assignee -->
            <div class="row form-group">
              <label for="assignee" class="col-xs-12 col-sm-2 col-form-label">Assignee</label>
              <div class="col-xs-12 col-sm-10">
                <select id="assignee" class="form-control" name="assignee_id" data-validation-required="Assignee is required"
                  data-disable-on="view,status_update" data-options-url="{{ route('api.users.index')  }}" data-option-text="name"
                  data-option-value="id" data-map-from="assignee.id" data-default-value="{{ $reporter_id }}" tabindex="5">
                  <option value="" selected>Not set</option>
                </select>
              </div>
            </div>
          </div>

          <!-- CLIENT DETAILS -->
          <div class="col col-xs-12 col-sm-4 detail-group">

            <!-- Client name -->
            <div class="row form-group">
              <label for="client_name" class="col-xs-12 col-sm-2 col-form-label">Name</label>
              <div class="col-xs-12 col-sm-10">
                <input id="client_name" type="text" class="form-control" name="client_name"
                  data-validation-required="Client name is required" data-disable-on="view,assign,status_update" data-map-from="client.name"
                  placeholder="Client name" tabindex="6" />
              </div>
            </div>

            <!-- Client email -->
            <div class="row form-group">
              <label for="client_email" class="col-xs-12 col-sm-2 col-form-label">Email</label>
              <div class="col-xs-12 col-sm-10">
                <input id="client_email" type="email" class="form-control" name="client_email"
                  data-validation-required="Client email is required" data-validation-email="Invalid email address"
                  data-disable-on="view,assign,status_update" data-map-from="client.email" placeholder="Client email" tabindex="7" />
              </div>
            </div>

          </div>

        </div>

        <!-- NAVIGATION TABS -->
        <ul class="nav nav-tabs d-flex flex-row w-100">
          <li class="ml-auto nav-item">
            <a class="nav-link active" href="#details" data-toggle="tab" data-tab="details">
              <i class="fa fa-info"></i> Details
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#comments" data-toggle="none" data-tab="comments">
              <i class="fa fa-comments"></i> Comments
            </a>
          </li>
          <li class="nav-item mr-5">
            <a class="nav-link disabled" href="#history" data-toggle="none" data-tab="activities">
              <i class="fa fa-history"></i> History
            </a>
          </li>
        </ul>
      </div>

      <div class="modal-body tab-content">
        <!-- Ticket Details -->
        <div id="details" class="tab-pane active">
          <div class="form-group">
            <textarea id="ticket_details" class="form-control ticket-details" id="ticket_details" name="ticket_details" rows="5" data-map-from="details" data-disable-on="view,assign,status_update"></textarea>
          </div>
        </div>

        <!-- Ticket Comments -->
        <div id="comments" class="tab-pane">

        </div>

        <!-- Ticket History -->
        <div id="history" class="tab-pane">

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-save px-2 py-1" data-mode="view">
            <i class="fa fa-save" title="Save Changes"></i> Save
          </button>
          <button type="reset" class="btn btn-secondary btn-clear px-2 py-1">
            <i class="fa fa-eraser" title="Clear Form"></i> Clear
          </button>
          <button type="button" class="btn btn-primary btn-edit px-2 py-1" data-mode="update">
            <i class="fa fa-edit" title="Edit Ticket"></i> Edit
          </button>
          <button type="button" class="btn btn-info btn-assign px-2 py-1" data-mode="assign">
            <i class="fa fa-user-cog" title="Assign Ticket"></i> Assign
          </button>
          <button type="button" class="btn btn-outline-secondary btn-cancel px-2 py-1" data-mode="view">
            <i class="fa fa-times" title="Cancel Changes"></i> Cancel
          </button>
        </div>
      </div>
  </form>
</div>
