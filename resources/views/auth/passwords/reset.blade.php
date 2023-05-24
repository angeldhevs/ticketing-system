{{--  @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}


@extends('layouts.app', [ 
    'bodyClass' => 'reset-password-form',
    'wrapperClass' => 'container'
    ])

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title text-center">
          <i class="fa fa-key"></i>
          {{ __('Reset Password') }}
        </h3>
        <hr />
        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
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
          @include('components.input', [
            'id' => 'password-confirm',
            'type' => 'password',
            'name' => 'password_confirmation',
            'placeholder' => 'Confirm Password',
            'class' => 'form-control',
            'attr' => [ 'required' ],
            'wrappers' => [ 
              'outer' => [ 'class' => 'form-group row' ],
              'inner' => [ 'class' => 'input-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3' ]
            ],
            'pre' => [ 'html' => '<i class="fa fa-check"></i>' ]
          ])
          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-primary">
                {{ __('Reset Password') }}
              </button>
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