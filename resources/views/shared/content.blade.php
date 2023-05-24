@php
$path = trim(Request::path(), '/');
$segments = explode('/', $path);
$buttons = isset($buttons) && is_array($buttons) ? $buttons : null;
$defaultHeaderTextTag = 'span';
@endphp

<main class="main-content @if(isset($wrapperClass)) {{ $wrapperClass }} @endif"
  @if(isset($wrapperId)) id="{{ $wrapperId }}" @endif>

  <!-- Page Header -->
  <div class="header-bar">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">
          <i class="fa fa-home"></i>
        </a>
      </li>
      @foreach ($segments as $segment)
        <li class="breadcrumb-item @if($loop->last) active @endif">{{ $segment }}</li>
      @endforeach
    </ol>

    @if(isset($include))
    @include('include')
    @elseif($buttons !== null)
    <div class="header-buttons btn-group">
      @foreach($buttons as $button)
        @if(!isset($button['includeIf']) || $button['includeIf'] == true)
          @if(isset($button['href']))
            <a href="{{ $button['href'] }}" class="btn">
              <i class="fa {{ $button['icon'] }}"></i>
            </a>
            @else
            <button class="btn" 
              @isset($button['toggle']) data-toggle="{{ $button['toggle'] }}" @endisset
              @isset($button['target']) data-target="{{ $button['target'] }}" @endisset>
              <i class="fa {{ $button['icon'] }}"></i>
            </button>
          @endif
        @endif
      @endforeach
    </div>
    @endif
  </div>
  <!-- Page Content -->
  <div class="content">
  @yield('content')
  </div>
</main>