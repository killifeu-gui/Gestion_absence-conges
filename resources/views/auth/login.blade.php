@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px;">
                    <h2 class="text-white mb-0" style="font-weight: 700;">{{ __('Se connecter') }}</h2>
                    <p class="text-white-50 mb-0 mt-2">{{ __('Accédez à votre compte') }}</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-600">{{ __('Adresse email') }}</label>
                            <input id="email" type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}"
                                required autocomplete="email" autofocus
                                placeholder="votre.email@exemple.com"
                                style="border-radius: 8px; border: 2px solid #e9ecef;">
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mot de passe avec voir/masquer -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-600">{{ __('Mot de passe') }}</label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password"
                                    placeholder="Votre mot de passe"
                                    style="border-radius: 8px 0 0 8px; border: 2px solid #e9ecef;">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password')"
                                    style="border: 2px solid #e9ecef; border-left: none; border-radius: 0 8px 8px 0;">
                                    <i class="bi bi-eye" id="password-icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Se souvenir de moi -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>
                        </div>

                        <!-- Bouton de connexion -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-lg fw-600"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 12px;">
                                {{ __('Se connecter') }}
                            </button>
                        </div>

                        <!-- Mot de passe oublié -->
                        @if (Route::has('password.request'))
                            <div class="text-center mb-3">
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #667eea;">
                                    {{ __('Mot de passe oublié?') }}
                                </a>
                            </div>
                        @endif

                        <!-- Lien vers inscription -->
                        <hr>
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                {{ __("Vous n'avez pas de compte?") }}
                                <a href="{{ route('register') }}" class="fw-600" style="color: #667eea; text-decoration: none;">
                                    {{ __('S\'inscrire') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
