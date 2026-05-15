@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px;">
                    <h2 class="text-white mb-0" style="font-weight: 700;">{{ __('Créer un compte') }}</h2>
                    <p class="text-white-50 mb-0 mt-2">{{ __('Inscrivez-vous pour gérer les absences et congés') }}</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-600">{{ __('Nom complet') }}</label>
                            <input id="name" type="text"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}"
                                required autocomplete="name" autofocus
                                placeholder="Votre nom complet"
                                style="border-radius: 8px; border: 2px solid #e9ecef;">
                            @error('name')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-600">{{ __('Adresse email') }}</label>
                            <input id="email" type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}"
                                required autocomplete="email"
                                placeholder="votre.email@exemple.com"
                                style="border-radius: 8px; border: 2px solid #e9ecef;">
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mot de passe avec voir/masquer -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-600">{{ __('Mot de passe') }}</label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password"
                                    placeholder="Entrez un mot de passe sécurisé"
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
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Au moins 8 caractères, incluant majuscules et chiffres
                            </small>
                        </div>

                        <!-- Confirmer le mot de passe avec voir/masquer -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-600">{{ __('Confirmer le mot de passe') }}</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password"
                                    class="form-control form-control-lg"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirmer le mot de passe"
                                    style="border-radius: 8px 0 0 8px; border: 2px solid #e9ecef;">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password-confirm')"
                                    style="border: 2px solid #e9ecef; border-left: none; border-radius: 0 8px 8px 0;">
                                    <i class="bi bi-eye" id="password-confirm-icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-lg fw-600"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 12px;">
                                {{ __('S\'inscrire') }}
                            </button>
                        </div>

                        <!-- Lien vers connexion -->
                        <div class="text-center mt-4">
                            <p class="text-muted">
                                {{ __('Vous avez déjà un compte?') }}
                                <a href="{{ route('login') }}" class="fw-600" style="color: #667eea; text-decoration: none;">
                                    {{ __('Se connecter') }}
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
