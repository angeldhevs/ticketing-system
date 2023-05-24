<label class="custom-checkbox"
  @if(isset($wrapper))
  @include('components.utils.attr', [ 'src' => $wrapper, 'name' => 'attr'])
  @include('components.utils.attr', [ 'src' => $wrapper, 'name' => 'data'])
  @endif
  >
  <input type="checkbox"
    {!! isset($id) ? 'id='.$id.' ' : ''!!}
    {!! isset($name) ? 'name='.$name.' ' : '' !!}
    {!! isset($checked) && $checked ? 'checked' : ''!!}
    @includeWhen(isset($attr), 'components.utils.attr', [ 'src' => $attr ?? null ])
    @includeWhen(isset($data), 'components.utils.attr', [ 'src' => $data ?? null, 'prefix' => 'data'])>
  <span class="check-mark"></span>
  <span class="checkbox-label">{{ $label }}</span>
</label>