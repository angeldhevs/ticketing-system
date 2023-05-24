@extends('layouts.app', [
'pageTitle' => 'Edit Role',
'header' => [
'icon' => 'fa-edit',
'text' => 'Edit Role'
]
])

@section('content')
<div class="container-fluid mt-3">
  <div class="row">
    <div class="col col-sm-12 col-md-6">
      <form method="POST" action="{{ route('manage.roles.update', [ 'id' => $role->id ]) }}">
        @csrf
        @method('PUT')
        @include('components.input', [
        'name' => 'name',
        'placeholder' => 'Enter '.__('Name'),
        'value' => old('name') ?? $role->name,
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
        'name' => 'name',
        'placeholder' => 'Enter '.__('Display name'),
        'value' => old('name'),
        'class' => $errors->has('name') ? 'is-invalid form-control' : 'form-control',
        'attr' => [
        'required',
        'autofocus',
        'autocomplete' => 'off'
        ],
        'label' => [
        'text' => __('Display name'),
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

        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
              {{ __('Submit') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/modules/manage/roles.js') }}"></script>
@endpush
