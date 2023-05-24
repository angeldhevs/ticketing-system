<{{ $wrapper['element'] ?? "span" }} class="row {{ $wrapper['class'] ?? "" }}">
    <{{ $label['element'] ?? "strong" }} class="{{ $label['class'] ?? "col col-sm-12 col-md-3" }}">{{ $label['name'] ?? "<field-name>" }}: </{{ $label['element'] ?? "strong" }}>
    <{{ $value['element'] ?? "span" }} class="{{ $value['class'] ?? "col col-sm-12 col-md-9" }}">
    @if($value['is_html'] ?? false)
        {!! $value['val'] ?? "<span>- Not set -</span>" !!}
    @else
        {{ $value['val'] ?? "- Not set -" }}
    @endif
    </{{ $value['element'] ?? "span" }}>
</{{ $wrapper['element'] ?? "span" }}>
