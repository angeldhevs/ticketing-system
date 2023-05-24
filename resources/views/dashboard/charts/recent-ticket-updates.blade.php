<div id="recent-ticket-updates" 
  class="card dashboard-chart" 
  data-source="{{ route('api.dashboard.recent-ticket-updates') }}">
  <div class="card-header p-2">
    <span class="card-title">
      Recent Updates
    </span>
  </div>
  <div class="card-body p-0">
    <table>
      <thead>
        <th>Ticket #</th>
        <th>Severity</th>
        <th>Status</th>
        <th>Assignee</th>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>