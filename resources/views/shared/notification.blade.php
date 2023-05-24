<li class="nav-item notifications dropdown">
    <a class="nav-link notification-toggle dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#notifications" data-resource-url="{{ route('api.notifications', [ 'unread' => 'true' ]) }}">
      <i class="fas fa-bell"></i>
      <span class="badge badge-danger notification-count">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdown">
      <div class="dropdown-header d-flex px-2">
        <strong>Notifications</strong>
        <span class="ml-auto">
          Unread <span class="notification-count">0</span>
        </span>
      </div>
      <div class="dropdown-container">
        <div class="dropdown-content">
          <span class="dropdown-item no-notification-message">No unread notification.</span> 
        </div>
      </div>
    </div>
  </li>