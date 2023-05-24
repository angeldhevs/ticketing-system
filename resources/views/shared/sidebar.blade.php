<nav id="sidebar-left" class="sidebar sidebar-dark shadow accordion">
  <div class="sidebar-header text-center">
    <span class="app-name">
        {{ config('app.name') }}
    </span>
  </div>
  @include('shared.menu')
  <ul class="nav flex-column sticky-bottom">
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fa fa-tools" aria-hidden="true"></i> <span>Settings</span>
      </a>
    </li>
  </ul>
</nav>
