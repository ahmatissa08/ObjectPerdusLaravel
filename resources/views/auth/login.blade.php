@extends('layouts.app')

@section('content')
<!-- Importation du CSS spécifique -->
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="container">
    <div class="login-container">
        <!-- En-tête -->
        <div class="login-header">{{ __('Login') }}</div>

        <!-- Formulaire -->
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <!-- Bouton de connexion -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-login">
                        {{ __('Login') }}
                    </button>
                </div>

                <!-- Lien mot de passe oublié -->
                <div class="text-center login-footer">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
