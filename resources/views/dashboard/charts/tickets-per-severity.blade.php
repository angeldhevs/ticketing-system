<div id="tickets-by-severity" 
  class="card dashboard-item" 
  data-source="{{ route('api.dashboard.tickets-per-severity') }}">
  <div class="card-header  p-2">
    <span class="card-title">Tickets per Severity</span>
  </div>
  <div class="card-body p-2">
    <canvas height="200"></canvas>
  </div>
</div>