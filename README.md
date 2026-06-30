# Plateforme de Gestion des Absences et Congés

## Description
Application web Laravel pour la gestion automatisée des congés et absences du personnel universitaire au Sénégal.

Fini les écritures à la main, désormais tout sera digitalisé !!!!
 Projet réalisé par #KILLIFEU-GUI et Alima.

## Fonctionnalités
- ✅ Gestion des agents avec calcul automatique des droits aux congés
- ✅ Enregistrement des absences autorisées
- ✅ Gestion des demandes de congé avec calcul des dates
- ✅ Rapports administratifs par direction/UFR
- ✅ Export PDF des rapports
- ✅ Historique complet par agent
- ✅ Dashboard avec statistiques
- ✅ Authentification admin/gestionnaire
- ✅ Interface Bootstrap responsive

## Installation

### Prérequis
- PHP 8.2+
- Composer
- MySQL
- Node.js (pour les assets)

### Étapes
1. Cloner le projet
2. `composer install`
3. `cp .env.example .env`
4. Configurer la base de données dans `.env`
5. `php artisan key:generate`
6. `php artisan migrate`
7. `php artisan db:seed`
8. `npm install && npm run build`
9. `php artisan serve`

## Utilisation

### Connexion
- Email: admin@example.com
- Mot de passe: password

### Fonctionnalités principales
1. **Agents**: Ajouter/modifier les agents avec calcul automatique des congés dus
2. **Absences**: Enregistrer les absences autorisées (déductibles ou non)
3. **Congés**: Créer des demandes de congé avec calcul automatique des dates
4. **Rapports**: Générer des rapports par direction/UFR avec export PDF

## Calculs automatiques
- Congés dus: 24 jours/an après 12 mois + 1 jour/enfant
- Dates de congé: Calcul des jours ouvrables (lundi-samedi, hors jours fériés)
- Jours restants: Congés dus - jours pris - absences déductibles

## Technologies
- Laravel 12
- Bootstrap 5
- MySQL
- DomPDF pour PDF
- Vite pour les assets

## Auteur
Plateforme développée pour l'Université du Sénégal

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
