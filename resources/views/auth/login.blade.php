@extends('layouts.app', [ 
    'bodyClass' => 'login-form',
    'wrapperClass' => 'container'
    ])

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title text-center">
          <i class="fa fa-sign-in-alt"></i>
          {{ __('Login') }}
        </h3>
        <hr />
        <form method="POST" action="{{ route('login') }}">
          @csrf
          @include('components.input', [
            'id' => 'email',
            'type' => 'email',
            'name' => 'email',
            'placeholder' => 'Email address',
            'class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control',
            'value' => old('email'),
            'attr' => [ 'required', 'autofocus' ],
            'wrappers' => [ 
              'outer' => [ 'class' => 'form-group row' ],
              'inner' => [ 'class' => 'input-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3' ]
            ],
            'pre' => [ 'html' => '<i class="fa fa-at"></i>' ],
            'error' => [
              'class' => 'invalid-feedback',
              'html' => '<strong>'.$errors->first('email').'</strong>'
            ]
          ])
          @include('components.input', [
            'id' => 'password',
            'type' => 'password',
            'name' => 'password',
            'placeholder' => 'Password',
            'class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control',
            'value' => old('password'),
            'attr' => [ 'required' ],
            'wrappers' => [ 
              'outer' => [ 'class' => 'form-group row' ],
              'inner' => [ 'class' => 'input-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3' ]
            ],
            'pre' => [ 'html' => '<i class="fa fa-asterisk"></i>' ],
            'error' => [
              'class' => 'invalid-feedback',
              'html' => '<strong>'.$errors->first('password').'</strong>'
            ]
          ])
          <div class="form-group row">
            <div class="col-md-6 offset-md-4">
              @include('components.checkbox', [
                'id' => 'remember',
                'name' => 'remember',
                'checked' => old('remember'),
                'label' => __('Remember Me')
              ])
            </div>
          </div>
          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
              </button>

              @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('Forgot Your Password?') }}
                </a>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modules/auth.css') }}" rel="stylesheet">
@endpush