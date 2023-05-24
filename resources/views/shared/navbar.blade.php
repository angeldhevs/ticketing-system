@php
$hasheader = isset($header) && is_array($header);
@endphp

<nav class="navbar navbar-laravel navbar-expand-md shadow">
  <div class="container-fluid">
    
    {{-- <button type="button" class="btn navbar-toggler toggler-left" data-target="#sidebar-left" data-toggle-class="show">
      <i class="fa fa-bars"></i>
    </button> --}}

    @if($hasheader) 
      <div class="navbar-page-title pl-md-2 pl-sm-0">
        @isset($header['icon'])
        <i class="header-icon fa {{ $header['icon'] }}"></i>
        @endisset
        @if(isset($header['text']))
        <span>{{ $header['text'] }}</span>
        @elseif(isset($header['html']))
        {!! $header['html'] !!}
        @endif
      </div>
    @endif

    <button type="button" class="navbar-toggler toggler-right btn" data-toggle="collapse" data-toggle-class="collapse" data-target="#right-menu" aria-controls="rightMenu" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fa fa-bars"></i>
    </button>
  
    <!-- Top-right menu -->
    <div class="collapse navbar-collapse" id="right-menu">
      <ul class="navbar-nav ml-md-auto mr-md-2 flex-sm-row justify-content-sm-center">
        @if (Auth::guest())
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
        @else
          <li class="nav-item mr-3">
            <ul class="navbar-nav flex-sm-row justify-content-sm-center">
              @include('shared.notification')
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            @include('shared.logout-form')
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>