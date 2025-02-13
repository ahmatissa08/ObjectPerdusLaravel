@extends('layouts.app')

@section('content')
<!-- Importation du CSS spécifique à cette page -->
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="container">
    <div class="register-container">
        <!-- En-tête -->
        <div class="register-header">{{ __('Register') }}</div>

        <!-- Formulaire -->
        <div class="register-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" required autocomplete="new-password">
                </div>

                <!-- Bouton d'inscription -->
                <div class="form-group">
                    <button type="submit" class="btn btn-register">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Pied de formulaire (optionnel, pour rediriger vers Login) -->
        <div class="register-footer">
            <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login') }}</a></p>
        </div>
    </div>
</div>
@endsection
