@php
  $hasWrappers = isset($wrappers);
  $hasOuterWrapper = $hasWrappers && isset($wrappers['outer']) && is_array($wrappers['outer']);
  $hasInnerWrapper = $hasWrappers && isset($wrappers['inner']) && is_array($wrappers['inner']);
  $hasLabel = isset($label) && is_array($label);
  $hasPrepend = isset($pre) && is_array($pre);
  $hasError = isset($error) && is_array($error);
  $hasDefault = isset($defaultOption) && is_array($defaultOption);
  $hasOptions = isset($options) && (is_array($options) || $options instanceof Collection);
@endphp

@if($hasOuterWrapper)
@php($outerWrap = $wrappers['outer'])
<div class="{{$outerWrap['class'] ?? 'form-group'}}"
  @include('components.utils.attr', [ 'src' => $outerWrap, 'name' => 'attr' ])
  @include('components.utils.attr', [ 'src' => $outerWrap, 'name' => 'data' ])>
@endisset

  {{-- Label customization --}}
  @if($hasLabel)
  <label for="{{$name}}"
    class="{{$label['class'] ?? ''}}"
    @include('components.utils.attr', [ 'src' => $label, 'name' => 'attr' ])
    @include('components.utils.attr', [ 'src' => $label, 'name' => 'data' ])>
    @if(isset($label['html']) && is_string($label['html']))
      {!! $label['html'] !!}
    @else
      {{ $label['text'] }}
    @endif
  </label>
  @endif

  {{-- Input wrapper customization --}}
  @if($hasInnerWrapper)
  @php($innerWrap = $wrappers['inner'])
  <div class="{{ $innerWrap['class'] ?? '' }}"
    @include('components.utils.attr', [ 'src' => $innerWrap, 'name' => 'attr' ])
    @include('components.utils.attr', [ 'src' => $innerWrap, 'name' => 'data' ])>
  @endif

  {{-- Prepend customization --}}
  @if($hasPrepend)
  <{{ $pre['tag'] ?? 'div' }}
    class="input-group-prepend {{ $pre['class'] ?? '' }}"
    @include('components.utils.attr', [ 'src' => $pre, 'name' => 'attr' ])
    @include('components.utils.attr', [ 'src' => $pre, 'name' => 'data' ])>
    <div class="input-group-text">
      @if(isset($pre['html']) && is_string($pre['html']))
        {!! $pre['html'] !!}
      @else
        {{ $pre['text'] }}
      @endif
    </div>
  </{{ $pre['tag'] ?? 'div' }}>
  @endif
    <input type="hidden" name="{{ $name ?? '' }}" />
    {{-- Select customization --}}
    <select
      id="{{ $id ?? '' }}"
      class="{{  $class ?? 'form-control' }}"
      name="{{ $name ?? '' }}"
      @includeWhen(isset($attr),'components.utils.attr', [ 'src' => [ 'attr' => $attr ?? null ], 'name' => 'attr' ])
      @includeWhen(isset($data),'components.utils.attr', [ 'src' => [ 'data' => $data ?? null ], 'name' => 'data' ])
      @includeWhen(isset($validation),'components.utils.attr', [ 'src' => [ 'validation' => $validation ?? null ], 'name' => 'validation', 'prefix' => 'data-validation' ])>
      @if($hasDefault)
      <option value=""
        @if(!isset($selectedOption)) selected @endif
        @includeWhen(isset($attr),'components.utils.attr', [ 'src' => $defaultOption, 'name' => 'attr' ])>
        {{ $defaultOption['text'] }}
      </option>
      @endif
      @if($hasOptions)
      @foreach ($options as $option)
      <option
        @if(isset($selectedOption)
          && ($option[$optionValue] == $selectedOption
          || $option[$optionText] == $selectedOption))
        selected
        @endif
        value="{{ $option[$optionValue] ?? $option[$optionText] ?? key($option) }}">
        {{ $option[$optionText] ?? $option[$optionValue] ?? '--' }}
      </option>
      @endforeach
      @endif
    </select>

    @if($hasError)
    <{{ $error['tag'] ?? 'span' }}
      @isset($error['class']) class="{{ $error['class'] }}"@endisset
      @include('components.utils.attr', [ 'src' => $error, 'name' => 'attr' ])
      @include('components.utils.attr', [ 'src' => $error, 'name' => 'data' ])>
      @if(isset($error['html']))
        {!! $error['html'] !!}
      @else
        {{ $error['text'] }}
      @endif
    </{{ $error['tag'] ?? "span" }}>
    @endif

  {{-- Include end div tag of wrapper if wrapper is set--}}
  @if($hasInnerWrapper)
  </div>
  @endif
  
@if($hasOuterWrapper)
</div>
@endif
