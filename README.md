# DB Digital Agency — CMS CodeIgniter 4

Site vitrine bilingue (FR/EN) avec back-office CMS, formulaires (contact, devis, newsletter), espace prospect et gestion SEO. Application **CodeIgniter 4** + **Shield** (authentification).

Ce document couvre l'installation locale et le **déploiement en production**.

---

## Sommaire

1. [Prérequis](#prérequis)
2. [Structure du projet](#structure-du-projet)
3. [Installation locale](#installation-locale)
4. [Déploiement en production](#déploiement-en-production)
5. [Configuration `.env](#configuration-env)`
6. [Base de données](#base-de-données)
7. [Assets et performance](#assets-et-performance)
8. [URLs et zones applicatives](#urls-et-zones-applicatives)
9. [Intégrations](#intégrations)
10. [Sécurité et permissions](#sécurité-et-permissions)
11. [Checklist post-déploiement](#checklist-post-déploiement)
12. [Dépannage](#dépannage)

---

## Prérequis


| Composant       | Version                                                                                             |
| --------------- | --------------------------------------------------------------------------------------------------- |
| PHP             | **8.2+** (extensions : `intl`, `mbstring`, `json`, `mysqlnd`, `xml`, `curl`, `fileinfo`, `openssl`) |
| MySQL / MariaDB | 5.7+ / 10.3+                                                                                        |
| Composer        | 2.x                                                                                                 |
| Serveur web     | Apache 2.4 (recommandé) ou Nginx                                                                    |
| Node.js         | 18+ (uniquement pour minifier les assets en production)                                             |


---

## Structure du projet

```
dbdigitalagency/
├── app/                    # Application CI4 (Controllers, Models, Views, Services, Migrations)
├── public/                 # Front controller web (index.php)
├── assets/                 # CSS, JS, images, polices (sources)
├── assets/build/           # CSS/JS minifiés (générés, non versionnés)
├── uploads/                # Médias et briefs devis (non versionné)
├── writable/               # Cache, logs, sessions (non versionné)
├── scripts/                # Apache, permissions, build assets
├── vendor/                 # Dépendances Composer (non versionné)
├── .env                    # Configuration locale / prod (non versionné)
├── .env.example            # Modèle de configuration
├── .htaccess               # Routage si DocumentRoot = racine du projet
├── spark                   # CLI CodeIgniter
└── composer.json
```

**Dépendances principales :** CodeIgniter 4, Shield (auth), PHPMailer, phpdotenv.

---

## Installation locale

### 1. Cloner et installer

```bash
git clone <url-du-repo> dbdigitalagency
cd dbdigitalagency
composer install
```

### 2. Environnement

```bash
cp .env.example .env
php spark key:generate
```

Éditez `.env` pour le développement :

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/dbdigitalagency/public/'
database.default.hostname = localhost
database.default.database = dbdigitalagency
database.default.username = root
database.default.password =
```

### 3. Base de données

```bash
# Créer la base MySQL, puis :
php spark migrate --all
php spark db:seed
```

Le compte admin initial est créé par `AdminUserSeeder` (voir [Compte admin](#compte-admin-initial)).

### 4. Permissions

```bash
./scripts/fix-writable-perms.sh
# ou avec sudo si nécessaire :
sudo WEB_USER=$(whoami) ./scripts/fix-writable-perms.sh
```

### 5. Serveur web local

**Apache (recommandé)**

```bash
sudo ./scripts/setup-apache.sh
```

Puis testez :

- `http://localhost/dbdigitalagency/fr`
- `http://localhost/dbdigitalagency/public/fr`
- `http://localhost/dbdigitalagency/admin` (redirige vers login)

**Sans Apache**

```bash
php spark serve
# → http://localhost:8080/fr
```

Dans ce cas, adaptez `app.baseURL` : `http://localhost:8080/`

---

## Déploiement en production

Procédure complète, de l'hébergement à la mise en ligne.

### Vue d'ensemble

```
┌─────────────┐    ┌──────────────┐    ┌─────────────────────────────┐
│   Git pull  │ →  │ composer     │ →  │ .env + php spark key:generate│
└─────────────┘    │ --no-dev     │    └─────────────────────────────┘
                   └──────────────┘              ↓
┌─────────────┐    ┌──────────────┐    ┌─────────────────────────────┐
│ HTTPS +     │ ←  │ permissions  │ ←  │ php spark migrate --all     │
│ vhost       │    │ writable/    │    │ php spark db:seed (1ère fois)│
└─────────────┘    │ uploads/     │    └─────────────────────────────┘
                   └──────────────┘              ↓
                                        ┌─────────────────────────────┐
                                        │ php spark assets:build       │
                                        │ ASSETS_MINIFIED=true         │
                                        └─────────────────────────────┘
```

### Étape 1 — Préparer l'hébergement

Hébergement **PHP 8.2+ / MySQL** (mutualisé ou VPS) avec certificat **SSL** (Let's Encrypt).

Créez :

- une base MySQL dédiée ;
- un utilisateur MySQL avec droits limités à cette base (évitez `root`).

### Étape 2 — Déployer le code

**Option A — Git (recommandé)**

```bash
ssh user@serveur
cd /var/www/html
git clone <url-du-repo> dbdigitalagency
cd dbdigitalagency
composer install --no-dev --optimize-autoloader
```

**Option B — SFTP**

Transférez les fichiers **sauf** `.env`, `vendor/`, `writable/cache/`*, `writable/logs/*`, `node_modules/`, puis exécutez `composer install --no-dev` sur le serveur.

### Étape 3 — Fichier `.env` de production

```bash
cp .env.example .env
nano .env
php spark key:generate
```

Paramètres essentiels :

```env
CI_ENVIRONMENT = production

app.baseURL = 'https://dbdigitalagency.com/'
app.indexPage = ''

APP_ENV = production
APP_DEBUG = false
APP_URL = 'https://dbdigitalagency.com'

database.default.hostname = localhost
database.default.database = votre_base
database.default.username = votre_user
database.default.password = 'votre_mot_de_passe'

SEO_INDEX = true
ASSETS_MINIFIED = true

ADMIN_SEED_EMAIL = admin@dbdigitalagency.com
ADMIN_SEED_PASSWORD = 'MotDePasseFortEtUnique!'
```

> **Important :** `app.baseURL` et `APP_URL` doivent être l'URL publique exacte, **avec** `https://` et **sans** `/public/` en production.

### Étape 4 — Base de données

**Premier déploiement :**

```bash
php spark migrate --all
php spark db:seed
```

**Mises à jour ultérieures :**

```bash
php spark migrate --all
```

> Le fichier `database.sql` à la racine est **legacy** (ancien site PHP). Le schéma CMS est géré exclusivement par les migrations CI4.

### Étape 5 — Permissions

```bash
sudo chown -R www-data:www-data /var/www/html/dbdigitalagency
sudo ./scripts/fix-writable-perms.sh
sudo chmod 640 .env
```

Le serveur web (`www-data`, `apache` ou `nginx`) doit pouvoir **écrire** dans :

- `writable/` (cache, logs, sessions)
- `uploads/` (médias CMS, briefs devis)

### Étape 6 — Virtual host

Deux configurations sont supportées. **La racine du projet** est recommandée : les dossiers `assets/` et `uploads/` sont servis directement par le `.htaccess` racine.

#### Apache — DocumentRoot = racine du projet (recommandé)

```apache
<VirtualHost *:443>
    ServerName dbdigitalagency.com
    ServerAlias www.dbdigitalagency.com
    DocumentRoot /var/www/html/dbdigitalagency

    <Directory /var/www/html/dbdigitalagency>
        Options FollowSymLinks
        AllowOverride All
        Require all granted
        FallbackResource public/index.php
    </Directory>

    SSLEngine on
    # Certificats SSL…
</VirtualHost>

# Redirection HTTP → HTTPS
<VirtualHost *:80>
    ServerName dbdigitalagency.com
    ServerAlias www.dbdigitalagency.com
    Redirect permanent / https://dbdigitalagency.com/
</VirtualHost>
```

Le fichier `[scripts/apache-dbdigitalagency.conf](scripts/apache-dbdigitalagency.conf)` reprend cette logique. Installation rapide :

```bash
sudo ./scripts/setup-apache.sh
```

#### Apache — DocumentRoot = `public/`

Si vous pointez le vhost vers `public/`, créez des liens symboliques :

```bash
cd /var/www/html/dbdigitalagency/public
ln -sfn ../assets assets
ln -sfn ../uploads uploads
```

Et configurez `app.baseURL` **sans** `/public/` : `https://dbdigitalagency.com/`

#### Nginx — DocumentRoot = racine du projet

```nginx
server {
    listen 443 ssl http2;
    server_name dbdigitalagency.com www.dbdigitalagency.com;
    root /var/www/html/dbdigitalagency;
    index index.php;

    # Fichiers statiques
    location ^~ /assets/ {
        try_files $uri =404;
        expires 30d;
        access_log off;
    }

    location ^~ /uploads/ {
        try_files $uri =404;
        location ~ \.php$ { deny all; }
    }

    location / {
        try_files $uri $uri/ /public/index.php/$uri$is_args$args;
    }

    location ~ ^/public/index\.php(/|$) {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.(env|git) {
        deny all;
    }
}
```

### Étape 7 — Assets minifiés

```bash
# Nécessite Node.js 18+ sur le serveur (ou en CI avant déploiement)
php spark assets:build
```

Activez ensuite les fichiers minifiés :

- dans **Admin → Intégrations**, ou
- via `ASSETS_MINIFIED=true` dans `.env`

### Étape 8 — SMTP et intégrations

Configurez l'envoi d'e-mails dans `.env` :

```env
SMTP_HOST = smtp.gmail.com
SMTP_PORT = 587
SMTP_USERNAME = votre-compte@gmail.com
SMTP_PASSWORD = 'mot-de-passe-application'
SMTP_ENCRYPTION = tls
SMTP_FROM_EMAIL = noreply@dbdigitalagency.com
SMTP_FROM_NAME = 'DB Digital Agency'
ADMIN_EMAIL = contact@dbdigitalagency.com
```

Les clés **reCAPTCHA** (site + secret), **Google Maps** et le **tracking** se configurent dans **Admin → Intégrations** (repli optionnel via `.env`).

### Étape 9 — Compte admin initial

```bash
php spark db:seed AdminUserSeeder
```

Identifiants définis par `ADMIN_SEED_EMAIL` et `ADMIN_SEED_PASSWORD` dans `.env`.

**Changez le mot de passe immédiatement** après la première connexion (`/login` → `/admin`).

---

## Configuration `.env`


| Variable               | Description                                     |
| ---------------------- | ----------------------------------------------- |
| `CI_ENVIRONMENT`       | `development` ou `production`                   |
| `app.baseURL`          | URL de base CI4, avec slash final               |
| `app.indexPage`        | Laisser vide (`''`) pour URLs propres           |
| `encryption.key`       | Généré par `php spark key:generate`             |
| `database.default.`*   | Connexion MySQL                                 |
| `APP_URL`              | URL publique (sitemap, canonical, e-mails)      |
| `APP_DEBUG`            | `false` en production                           |
| `SMTP_*` / `email.*`   | Envoi des e-mails transactionnels               |
| `ADMIN_EMAIL`          | Destinataire des notifications formulaires      |
| `SEO_INDEX`            | `true` = indexation Google ; `false` en préprod |
| `RECAPTCHA_SECRET_KEY` | Repli clé secrète reCAPTCHA (sinon Admin → Intégrations) |
| `GOOGLE_MAPS_API_KEY`  | Optionnel — Google Maps (sinon Leaflet/OSM)     |
| `ASSETS_MINIFIED`      | `true` pour servir `assets/build/`              |
| `ADMIN_SEED_*`         | Compte admin créé par le seeder                 |


Modèle complet : `[.env.example](.env.example)`.

---

## Base de données


| Commande                            | Usage                                                 |
| ----------------------------------- | ----------------------------------------------------- |
| `php spark migrate --all`           | Applique toutes les migrations                        |
| `php spark migrate:rollback`        | Annule la dernière migration                          |
| `php spark db:seed`                 | Charge le contenu initial (pages, menus, SEO, admin…) |
| `php spark db:seed AdminUserSeeder` | Recrée ou met à jour le compte admin                  |


**Tables principales :** pages, services, projets, blog, équipe, témoignages, menus, traductions, médias, branding, settings, SEO (meta + redirections), quotes, contacts, newsletter, logs admin.

---

## Assets et performance


| Mode          | Commande / réglage                                   |
| ------------- | ---------------------------------------------------- |
| Développement | Assets sources dans `assets/css/`, `assets/js/`      |
| Production    | `php spark assets:build` puis `ASSETS_MINIFIED=true` |


Le build génère `assets/build/manifest.json` (mapping + hash pour cache-busting).

**CDN optionnel :** URL configurable dans Admin → Intégrations (`CDN_ASSETS_URL`).

---

## URLs et zones applicatives

Avec `app.baseURL = 'https://dbdigitalagency.com/'` :


| Zone               | URL                        |
| ------------------ | -------------------------- |
| Accueil FR         | `/fr`                      |
| Accueil EN         | `/en`                      |
| Contact FR         | `/fr/contact`              |
| Devis FR           | `/fr/devis`                |
| Sitemap            | `/sitemap.xml`             |
| Login admin        | `/login`                   |
| Back-office CMS    | `/admin`                   |
| Espace prospect    | `/prospect/access/{token}` |
| Connexion prospect | `/user/login`              |


**Redirections legacy :** les anciennes URLs (`about.php`, `contact.php`, `get-quote.php`, `sitemap.php`…) redirigent en 301 vers les routes CI4 (configurées dans `.htaccess`).

---

## Intégrations


| Service                   | Configuration                                                |
| ------------------------- | ------------------------------------------------------------ |
| E-mails (contact, devis)  | `.env` (`SMTP_`*) + Admin → Intégrations                     |
| reCAPTCHA v3              | Site Key + Secret Key dans Admin → Intégrations             |
| Google Maps               | Clé API dans `.env` ou Admin (sinon Leaflet + OpenStreetMap) |
| Tracking (GA, GTM, Meta…) | Admin → Intégrations                                         |
| TinyMCE (éditeur admin)   | Clé API dans Admin → Intégrations                            |


---

## Sécurité et permissions

- Ne **jamais** committer `.env`, `vendor/`, `writable/`, `uploads/`, `node_modules/`
- `CI_ENVIRONMENT=production` et `APP_DEBUG=false` en production
- `encryption.key` unique par environnement (`php spark key:generate`)
- Protéger `.env` au niveau serveur (refus d'accès HTTP)
- Interdire l'exécution de PHP dans `uploads/`
- HTTPS obligatoire
- Mot de passe d'application SMTP (pas le mot de passe du compte)
- Changer `ADMIN_SEED_PASSWORD` après le premier déploiement

**Fichiers sensibles exclus du dépôt** (voir `[.gitignore](.gitignore)`).

---

## Checklist post-déploiement

- `composer install --no-dev` exécuté
- `.env` configuré (`app.baseURL`, `APP_DEBUG=false`, base, SMTP, `encryption.key`)
- `php spark migrate --all` exécuté
- Seeders lancés (premier déploiement)
- Mot de passe admin changé
- Permissions `writable/` et `uploads/` OK
- HTTPS actif, redirection HTTP → HTTPS
- `php spark assets:build` + `ASSETS_MINIFIED=true`
- Formulaire contact testé (e-mail + enregistrement en base)
- Formulaire devis testé (avec et sans pièce jointe)
- Newsletter testée
- Navigation FR/EN fonctionnelle
- `/sitemap.xml` accessible
- Redirections legacy vérifiées (`contact.php` → `/fr/contact`, etc.)
- `SEO_INDEX=true` uniquement quand le site est prêt
- Sitemap soumis à [Google Search Console](https://search.google.com/search-console)

---

## Dépannage

### Erreur de connexion à la base

- Vérifier `database.default.`* dans `.env`
- Confirmer que la base existe et que l'utilisateur a les droits

### Erreur 404 sur toutes les pages (sauf accueil Apache)

- Activer `mod_rewrite` et `AllowOverride All`
- Vérifier `FallbackResource` (Apache) ou la règle `try_files` (Nginx)
- En local : `sudo ./scripts/setup-apache.sh`

### Erreur 500

- Vérifier `vendor/` (`composer install`)
- Vérifier les extensions PHP (`intl`, `mbstring`, `mysqlnd`)
- Consulter `writable/logs/log-*.log`
- En préprod uniquement : `CI_ENVIRONMENT=development` pour afficher les erreurs

### Les e-mails ne partent pas

- Vérifier `SMTP_*` dans `.env`
- Tester avec un mot de passe d'application (Gmail) ou le SMTP de l'hébergeur
- Vérifier les logs dans `writable/logs/`

### Assets CSS/JS introuvables (404)

- Vérifier que `assets/` est accessible (DocumentRoot = racine, ou symlinks dans `public/`)
- Vérifier `app.baseURL` (pas de `/public/` en prod avec DocumentRoot racine)

### Upload de brief échoue

- Permissions d'écriture sur `uploads/`
- `upload_max_filesize` et `post_max_size` dans `php.ini` (≥ `QUOTE_BRIEF_MAX_MB`, défaut 2 Mo)

### Canonical ou sitemap incorrects

- `app.baseURL` et `APP_URL` doivent correspondre exactement à l'URL publique (`https://domaine.com/`, slash final)

### Permission denied sur `writable/`

```bash
sudo ./scripts/fix-writable-perms.sh
```

---

## Commandes utiles

```bash
php spark migrate --all          # Migrations
php spark db:seed                # Contenu initial
php spark assets:build           # Minification CSS/JS
php spark key:generate           # Clé de chiffrement
php spark routes                 # Liste des routes
php spark serve                  # Serveur de dev intégré
```

---

## Support

- **Contenu et SEO :** back-office `/admin`
- **Traductions :** Admin → Traductions
- **Branding (logo, favicon, couleurs) :** Admin → Branding
- **Redirections SEO :** Admin → SEO

Pour toute évolution technique, se référer au code dans `app/` et aux migrations dans `app/Database/Migrations/`.