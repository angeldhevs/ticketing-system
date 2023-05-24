<ul class="nav flex-column main-menu">
  <hr class="sidebar-divider my-0" />
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fa fa-tachometer-alt" aria-hidden="true"></i> <span>Dashboard</span>
    </a>
  </li>
  <hr class="sidebar-divider my-0" />
  <li class="nav-item">
    <a class="nav-link" href="{{ route('tickets.index') }}">
      <i class="fa fa-ticket-alt" aria-hidden="true"></i> <span>Tickets</span>
    </a>
  </li>
  {{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('reports.index') }}">
      <i class="fa fa-chart-bar" aria-hidden="true"></i> <span>Reports</span>
    </a>
  </li> --}}
  <hr class="sidebar-divider my-0" />
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage-menu" aria-expanded="false">
      <i class="fa fa-cogs" aria-hidden="true"></i> <span>Manage</span>
    </a>
    <ul id="manage-menu" class="nav flex-column collapse">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('manage.users.index') }}">
          <i class="fa fa-users" aria-hidden="true"></i> <span>Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('manage.roles.index') }}">
          <i class="fa fa-scroll" aria-hidden="true"></i> <span>Roles</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/manage/features">
          <i class="fa fa-desktop" aria-hidden="true"></i> <span>Features</span>
        </a>
      </li>
    </ul>
  </li>
  <hr class="sidebar-divider my-0" />
</ul>
