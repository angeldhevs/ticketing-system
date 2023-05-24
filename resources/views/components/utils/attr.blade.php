@php
  $hasSrc = isset($src) && is_array($src);
  $hasName = isset($name) && is_string($name);
  $hasPrefix = isset($prefix) && is_string($prefix);
  $elements = $hasSrc ? ($hasName && array_key_exists($name, $src) && is_array($src[$name]) ? $src[$name] : null) : null;
  $hasElements = $elements !== null;
@endphp

@if($hasSrc && $hasElements)
  @foreach(array_keys($elements) as $key)
    @if(is_numeric($key))
      {{ $elements[$key] }}
    @elseif($hasPrefix)
      {{ $prefix.'-'.$key }}="{{ $elements[$key] }}"
    @elseif($hasName && $name !== 'attr')
      {{ $name.'-'.$key }}="{{ $elements[$key] }}"
    @else
    {{ $key }}="{{ $elements[$key] }}"
    @endif
  @endforeach
@endif

