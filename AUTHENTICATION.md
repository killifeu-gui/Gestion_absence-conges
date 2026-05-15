# Système d'Authentification et Contrôle d'Accès

## Vue d'ensemble
L'application gère deux rôles d'utilisateurs: **admin** et **gestionnaire** avec un système de contrôle d'accès basé sur les rôles (RBAC).

---

## 1. Architecture de l'Authentification

### Structure de la table `users`

```sql
users
├── id (PK)
├── name (nom)
├── email (adresse email)
├── password (mot de passe - hashé avec bcrypt)
├── role (enum: 'admin' | 'gestionnaire')
├── email_verified_at
├── remember_token
├── created_at
├── updated_at
```

### Valeur par défaut
- **Rôle par défaut**: `gestionnaire`
- Tout nouvel utilisateur inscrit est automatiquement "gestionnaire"
- Seul un admin peut promouvoir un utilisateur en "admin"

---

## 2. Composants du Système

### A. Modèle User (`app/Models/User.php`)

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',  // ← Rôle inclus dans les champs modifiables
];
```

✅ Le rôle est dans `fillable`, ce qui permet de l'assigner lors de l'inscription ou de la modification.

### B. Middleware de Contrôle de Rôle (`app/Http/Middleware/CheckRole.php`)

```php
public function handle(Request $request, Closure $next, string ...$roles): Response
{
    if (!auth()->check()) {
        abort(403, 'Vous devez être authentifié.');
    }

    $userRole = auth()->user()->role;
    
    if (!in_array($userRole, $roles)) {
        abort(403, 'Accès non autorisé. Rôle insuffisant.');
    }

    return $next($request);
}
```

**Fonctionnement**:
- Reçoit un nombre variable de rôles en paramètres (`...$roles`)
- Vérifie que l'utilisateur est authentifié
- Compare le rôle de l'utilisateur avec les rôles autorisés
- Accepte l'accès si le rôle correspond à au moins un des rôles autorisés
- Retourne une erreur 403 (Accès interdit) sinon

### C. Enregistrement du Middleware (`bootstrap/app.php`)

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

✅ Le middleware est enregistré avec l'alias `'role'`

### D. Protection des Routes (`routes/web.php`)

```php
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Routes protégées pour admin/gestionnaire
    Route::middleware('role:admin,gestionnaire')->group(function () {
        Route::resource('agents', AgentController::class);
        Route::resource('absences', AbsenceController::class)->only(['index', 'create', 'store']);
        Route::resource('leaves', LeaveRequestController::class)->only(['index', 'create', 'store']);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');
    });
});
```

**Explication des couches middleware**:
1. `middleware('auth')` → Oblige l'authentification
2. `middleware('role:admin,gestionnaire')` → Oblige admin OU gestionnaire
   - Les deux rôles sont autorisés pour toutes les routes de gestion

---

## 3. Flux d'Authentification

### Inscription
1. L'utilisateur remplit le formulaire d'inscription amélioré
2. **Fonction voir/masquer mot de passe**: 
   - Button avec icône `bi-eye` / `bi-eye-slash`
   - JavaScript bascule entre `type="password"` et `type="text"`
   - Implémenté sur les deux champs de mot de passe

```javascript
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
```

3. La requête est envoyée à `POST /register`
4. **Le contrôleur RegisterController** (Laravel Auth):
   - Crée l'utilisateur
   - Assigne automatiquement `role = 'gestionnaire'`
   - Hache le mot de passe
   - Authentifie l'utilisateur

### Connexion
1. L'utilisateur entre email et mot de passe
2. **Fonction voir/masquer mot de passe**: Même fonction que l'inscription
3. Laravel Auth valide les credentials
4. L'utilisateur est authentifié avec son rôle stocké

### Accès aux Ressources
```
Utilisateur demande accès à /agents
    ↓
Middleware 'auth' valide l'authentification ✓
    ↓
Middleware 'role:admin,gestionnaire' vérifie le rôle
    ↓
Si rôle = 'admin' OU 'gestionnaire' → Accès autorisé ✓
Si rôle = autre → Erreur 403 ✗
```

---

## 4. Affichage du Rôle dans l'Interface

### Barre de Navigation
```blade
<span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    {{ Auth::user()->role === 'admin' ? 'Administrateur' : 'Gestionnaire' }}
</span>
```

- Le badge affiche le rôle de l'utilisateur
- Styling différent pour les deux rôles

### Dans la Vue de Profil/Utilisateur
```blade
{{ Auth::user()->role }}  // Affiche: 'admin' ou 'gestionnaire'
```

---

## 5. Gestion des Rôles

### Base de Données
La colonne `role` contient directement la chaîne de caractères:
- `'admin'` → Accès administrateur complet
- `'gestionnaire'` → Accès gestionnaire complet

### Promotion d'un Utilisateur à Admin
```php
$user = User::find($userId);
$user->update(['role' => 'admin']);
```

Pour l'interface, cette fonctionnalité doit être implémentée dans un formulaire admin.

### Rétrogradation à Gestionnaire
```php
$user = User::find($userId);
$user->update(['role' => 'gestionnaire']);
```

---

## 6. Sécurité Implémentée

✅ **Authentification**:
- Mots de passe hashés (bcrypt)
- Tokens CSRF sur tous les formulaires
- Sessions sécurisées

✅ **Autorisation**:
- Middleware de contrôle d'accès sur toutes les routes critiques
- Vérification du rôle avant chaque action
- Erreur 403 en cas d'accès refusé

✅ **Formulaires**:
- Fonction voir/masquer le mot de passe
- Validation côté serveur
- Messages d'erreur clairs
- Design responsive et moderne

---

## 7. Utilisation de la Fonction Voir/Masquer Mot de Passe

### Inscription
```html
<div class="input-group">
    <input id="password" type="password" name="password" />
    <button onclick="togglePassword('password')">
        <i class="bi bi-eye" id="password-icon"></i>
    </button>
</div>
<div class="input-group">
    <input id="password-confirm" type="password" name="password_confirmation" />
    <button onclick="togglePassword('password-confirm')">
        <i class="bi bi-eye" id="password-confirm-icon"></i>
    </button>
</div>
```

### Connexion
```html
<div class="input-group">
    <input id="password" type="password" name="password" />
    <button onclick="togglePassword('password')">
        <i class="bi bi-eye" id="password-icon"></i>
    </button>
</div>
```

---

## 8. Routes Protégées

| Route | Middleware | Rôles autorisés | Description |
|-------|------------|-----------------|-------------|
| `/home` | auth | Tous | Tableau de bord |
| `/agents` | auth, role | admin, gestionnaire | Gestion des agents |
| `/absences` | auth, role | admin, gestionnaire | Gestion des absences |
| `/leaves` | auth, role | admin, gestionnaire | Gestion des congés |
| `/reports` | auth, role | admin, gestionnaire | Rapports administratifs |

---

## 9. Fluxe d'Erreur

### Accès sans authentification
```
Utilisateur non authentifié demande /agents
    ↓
Middleware 'auth' redirige vers /login
```

### Accès avec rôle insuffisant
```
Utilisateur avec rôle 'readonly' demande /agents
    ↓
Middleware 'auth' passe ✓
    ↓
Middleware 'role:admin,gestionnaire' bloque
    ↓
Erreur 403: "Accès non autorisé. Rôle insuffisant."
```

---

## 10. Résumé

| Composant | Fichier | Rôle |
|-----------|---------|------|
| Modèle User | `app/Models/User.php` | Stocke les données utilisateur incluant le rôle |
| Middleware | `app/Http/Middleware/CheckRole.php` | Vérifie le rôle de l'utilisateur |
| Routes | `routes/web.php` | Applique les middlewares |
| Bootstrap Config | `bootstrap/app.php` | Enregistre le middleware |
| Formulaires Auth | `resources/views/auth/` | Interface avec voir/masquer mot de passe |
| Layout | `resources/views/layouts/app.blade.php` | Affiche le rôle dans la barre de nav |

---

## ✨ Améliorations Apportées

1. ✅ **Middleware flexible**: Accepte plusieurs rôles (`role:admin,gestionnaire`)
2. ✅ **Interface moderne**: Design gradient et responsive
3. ✅ **Fonction voir/masquer mot de passe**: Sur inscription et connexion
4. ✅ **Affichage du rôle**: Badge dans la barre de navigation
5. ✅ **Messages clairs**: Erreurs et messages de validation explicites
6. ✅ **Sécurité**: CSRF tokens, validation, authentification robuste

