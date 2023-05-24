@extends('layouts.app', [
  'pageTitle' => 'Edit User',
  'header' => [
    'icon' => 'fa-user-edit',
    'text' => 'Edit User'
  ]
])

@section('content')
<div class="container-fluid mt-3">
  <div class="row">
    <div class="col col-sm-12 col-md-6">
      <form method="POST" action="{{ route('manage.users.update', [ 'id' => $user->id ]) }}"  data-method="PATCH">
        @csrf
        @method('PATCH')
        <input type="hidden" value="{{ $user->id }}" name="id">
        @include('components.input', [
          'name' => 'name',
          'placeholder' => 'Enter '.__('Name'),
          'value' => old('name') ?? $user->name,
          'class' => $errors->has('name') ? 'is-invalid form-control' : 'form-control',
          'attr' => [
              'required',
              'autofocus',
              'autocomplete' => 'off'
          ],
          'label' => [
              'text' => __('Name'),
              'class' => 'col-md-4 col-form-label text-md-right'
          ],
          'wrappers' => [
              'outer' => [ 'class' => 'form-group row' ],
              'inner' => [ 'class' => 'col-sm-12 col-md-8' ]
          ],
          'error' => [
              'tag' => 'small',
              'html' => '<strong>'.$errors->first('name').'</strong>'
          ]
        ])

        @include('components.input', [
          'name' => 'email',
          'type' => 'email',
          'placeholder' => 'Enter '.__('E-Mail Address'),
          'value' =>  old('email') ?? $user->email,
          'class' => $errors->has('email') ? ' is-invalid form-control' : 'form-control',
          'attr' => [
              'required',
              'autocomplete' => 'off'
          ],
          'label' => [
              'text' => __('E-Mail Address'),
              'class' => 'col-md-4 col-form-label text-md-right'
          ],
          'wrappers' => [
              'outer' => [ 'class' => 'form-group row' ],
              'inner' => [ 'class' => 'col-sm-12 col-md-8' ]
          ],
          'error' => [
              'tag' => 'small',
              'html' => '<strong>'.$errors->first('email').'</strong>'
          ]
        ])

        @include('components.select', [
          'name' => 'role_id',
          'options' => $roles,
          'optionValue' => 'id',
          'optionText' => 'display_name',
          'selectedOption' => old('role_id') ?? $user->roles[0]->id,
          'label' => [
              'text' => 'Role',
              'class' => 'col-md-4 col-form-label text-md-right'
          ],
          'wrappers' => [
              'outer' => [ 'class' => 'form-group row' ],
              'inner' => [ 'class' => 'col-sm-12 col-md-8' ]
          ],
          'defaultOption' => [ 'text' => 'Select...' ]
        ])

        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
              {{ __('Update') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/modules/manage/users.js') }}" ></script>
@endpush
