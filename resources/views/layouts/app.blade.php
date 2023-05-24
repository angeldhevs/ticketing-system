@php
$content = [];
if(isset($buttons)) array_merge($content, [ 'buttons' => $buttons]);
if(isset($wrapperId)) array_merge($content, [ 'wrapperId' => $wrapperId]);

$user = Auth::user();
if( $user !== null) {
  JavaScript::put([
    'User' => [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email
    ],
  ]);
}
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>{!! !empty($pageTitle) ? $pageTitle." | " : "" !!}Ticketing System</title>

  <!-- Section: Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @auth
  <meta name="api-token" content="{{ Auth::user()->api_token }}">
  @endauth

  <!-- Section: Stylesheets -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/bootstrap.min.css"/>
  @stack('styles')
</head>
@include('components.spinner')
<!-- You can specify one or more class from the partial view that uses this layout by supplying the following variables. -->
<body @if(isset($bodyClass))class={{ $bodyClass }}@endif>
  <!-- Section: Content -->
  @if(auth()->check())
    <div class="outer-wrapper d-flex w-100 align-content-stretch">
      @include('shared.sidebar')
      <div class="inner-wrapper d-flex w-100 align-content-stretch flex-column">
        @include('shared.navbar', [ 'header' => $header ] )
        @include('shared.content', $content)
      </div>
    </div>
    @include('tickets.modal', [
      'reporter_id' => $reporter_id ?? Auth::user()->id,
      'reporter_name' => $reporter_name ?? Auth::user()->name,
      'source_id' => $source_id ?? Auth::user()->id
    ])
  @else
    <div class="container">
      @yield('content')
    </div>
  @endif

  <!-- Section: Scripts -->
  <script type="text/javascript" src="{{ asset('js/lib.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/utils.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/components.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      let $document = $(document);
      //Initialize TinyMCE
      tinyMCE.init({
          theme : "silver",
          mode : "textareas",
          menubar: false,
          statusbar: false,
          toolbar: 'undo redo | formatselect | bold italic underline backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
      });

      // Include the csrf token for all ajax requests.
      $document.ajaxSend(function(evt, xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        xhr.setRequestHeader('Authorization', 'Bearer ' + $('meta[name="api-token"]').attr('content'));
      })

      //Global: shows a spinner when submitting a form.
      $document.on('submit', 'form', function(evt) {
          $.spinner('show');
          $(evt.currentTarget)
              .find('[type=submit]')
              .addClass('disabled')
              .attr('disabled', true);

          return true;
      });

      //TinyMCE: For Editors inside Bootstrap's modal
      $document.on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
          e.stopImmediatePropagation();
        }
      });

      //Global: Set hidden input on select change.
      $document.on('change', 'select', function(e) {
        let $select = $(e.currentTarget);
        let $hidden = $document.find(`input[name=${$select.attr('name')}]`);
        $hidden.val($select.val());
      }.bind(this));
    });
  </script>
  <script type="text/javascript" src="{{ asset('js/modules/notification.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/modules/ticket/modal.js') }}"></script>

  <!-- Render custom scripts from partial views -->
  @stack('scripts')
</body>
</html>
