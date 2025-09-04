# Laravel – README
Application Laravel (v12.22.1) utilisant MySQL, Vite/Tailwind pour le front, et des files d’attente via la connexion “database”.
## Fonctionnalités principales
- Backend Laravel 12 avec PHP 8.2
- Base de données MySQL
- Files d’attente (queue) via la base de données
- Front-end avec Vite et Tailwind CSS
- Tests avec PHPUnit

## Prérequis
- PHP 8.2+
- Composer 2.x
- MySQL 8.x (ou compatible)
- Node.js 18+ et npm
- Optionnel: Docker + Docker Compose (Laravel Sail)

## Installation
1. Cloner le dépôt
``` bash
git clone <url-du-repo>
cd <dossier-du-projet>
```
1. Installer les dépendances PHP
``` bash
composer install
```
1. Installer les dépendances Node
``` bash
npm install
```
1. Créer le fichier d’environnement
``` bash
cp .env.example .env
php artisan key:generate
```
1. Configurer la base de données dans .env
``` dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```
1. Configurer la file d’attente (database)
``` dotenv
QUEUE_CONNECTION=database
```
1. Migrations (et tables de queue)
``` bash
php artisan queue:table
php artisan migrate
```
1. (Optionnel) Données de démo
``` bash
php artisan db:seed
```
## Lancement en développement
- Démarrer le serveur Laravel
``` bash
php artisan serve
```
- Démarrer Vite (front)
``` bash
npm run dev
```
- Démarrer le worker de file d’attente
``` bash
php artisan queue:work
```
Astuce: exécuter les trois en parallèle (si vous le souhaitez) avec un gestionnaire de terminaux ou le package “concurrently”.
## Compilation front
- Développement avec HMR:
``` bash
npm run dev
```
- Build de production:
``` bash
npm run build
```
## Tests
- Exécuter la suite PHPUnit:
``` bash
php artisan test
# ou
vendor/bin/phpunit
```
## Utilisation avec Docker (Laravel Sail)
1. Installer Sail (si nécessaire)
``` bash
php artisan sail:install
```
1. Démarrer les services
``` bash
./vendor/bin/sail up -d
```
1. Exécuter les commandes via Sail
``` bash
./vendor/bin/sail php artisan migrate
./vendor/bin/sail npm run dev
./vendor/bin/sail php artisan queue:work
```
## Variables d’environnement recommandées
- Application
``` dotenv
APP_NAME="Laravel"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost
```
- Base de données
``` dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```
- Files d’attente
``` dotenv
QUEUE_CONNECTION=database
```
- Cache/Session (exemples)
``` dotenv
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
```
## Journalisation
- Basée sur Monolog. Configurable via le canal “stack” et APP_ENV/LOG_CHANNEL/LOG_LEVEL dans .env.

## Déploiement (aperçu rapide)
- Construire les assets:
``` bash
npm ci
npm run build
```
- Dépendances et optimisations:
``` bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
- Lancer le worker:
``` bash
php artisan queue:work --daemon --stop-when-empty
# ou superviser via Supervisor/Systemd
```
## Dépannage
- Problèmes d’autorisations (stockage/cache):
``` bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```
- Erreurs de cache en dev:
``` bash
php artisan optimize:clear
```
