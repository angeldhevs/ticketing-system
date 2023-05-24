<div id="new-vs-closed-tickets" 
  class="card dashboard-item" 
  data-source="{{ route('api.dashboard.new-vs-closed-tickets') }}">
  <div class="card-header p-2">
    <span class="card-title float-left my-1">New vs Closed Tickets</span>
    <div class="input-group m-0 col-sm-5 col-md-3 float-right">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="fa fa-calendar"></i>
        </div>
      </div>
      <input type="text" class="form-control form-control-sm readonly" readonly placeholder="Select date range" name="date-range">
    </div>
  </div>
  <div class="card-body p-2">
    <canvas height="250"></canvas>
  </div>
</div>