# DB Digital Agency — Site vitrine

Site vitrine bilingue (FR/EN) en **PHP natif**, sans framework. Ce document décrit comment installer le projet en local et le mettre en ligne en production.

---

## Sommaire

1. [Prérequis](#prérequis)
2. [Structure du projet](#structure-du-projet)
3. [Installation en local](#installation-en-local)
4. [Mise en ligne (production)](#mise-en-ligne-production)
5. [Configuration `.env`](#configuration-env)
6. [Base de données](#base-de-données)
7. [Formulaires et e-mails](#formulaires-et-e-mails)
8. [Cartes interactives](#cartes-interactives)
9. [SEO](#seo)
10. [Sécurité et permissions](#sécurité-et-permissions)
11. [Checklist post-déploiement](#checklist-post-déploiement)
12. [Dépannage](#dépannage)

---

## Prérequis

| Composant | Version recommandée |
|-----------|---------------------|
| PHP | 8.1+ (extensions : `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `json`, `session`) |
| MySQL / MariaDB | 5.7+ / 10.3+ |
| Composer | 2.x |
| Serveur web | Apache 2.4 ou Nginx |

Extensions PHP utiles : `curl`, `zip` (pour Composer).

---

## Structure du projet

```
dbdigitalagency/
├── assets/              # CSS, JS, images, polices
├── components/          # Sections réutilisables (équipe, témoignages, cartes…)
├── includes/            # Config, fonctions, traitements formulaires
│   ├── config.php
│   ├── functions.php
│   ├── db.php
│   ├── process-contact.php
│   ├── process-quote.php
│   └── process-newsletter.php
├── uploads/quotes/      # Briefs PDF/DOCX (créé au déploiement, non versionné)
├── vendor/              # Dépendances Composer (non versionné)
├── .env                 # Variables d'environnement (non versionné)
├── .env.example         # Modèle de configuration
├── database.sql         # Schéma MySQL
├── composer.json
├── index.php            # Accueil
├── contact.php
├── get-quote.php
└── sitemap.php
```

**Dépendances Composer :**
- `vlucas/phpdotenv` — chargement du fichier `.env`
- `phpmailer/phpmailer` — envoi des e-mails (contact, devis, newsletter)

---

## Installation en local

### 1. Cloner le dépôt

```bash
git clone <url-du-repo> dbdigitalagency
cd dbdigitalagency
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Créer le fichier d'environnement

```bash
cp .env.example .env
```

Éditez `.env` pour le développement local :

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/dbdigitalagency
```

### 4. Créer la base de données

```bash
mysql -u root -p < database.sql
```

Adaptez `DB_HOST`, `DB_NAME`, `DB_USER` et `DB_PASS` dans `.env` si nécessaire.

### 5. Préparer le dossier d'uploads

```bash
mkdir -p uploads/quotes
chmod 755 uploads uploads/quotes
```

### 6. Configurer le serveur web

**Apache** — pointer le `DocumentRoot` vers la racine du projet (ou placer le projet dans `htdocs` / `www`).

**PHP built-in server** (tests rapides uniquement) :

```bash
php -S localhost:8000
```

### 7. Vérifier

Ouvrez `http://localhost/dbdigitalagency/` (ou l'URL configurée) et testez :
- navigation FR/EN (`?lang=fr` / `?lang=en`)
- formulaire de contact
- formulaire de devis (`get-quote.php`)
- newsletter (footer)

---

## Mise en ligne (production)

### Étape 1 — Hébergement

Choisissez un hébergement **mutualisé PHP + MySQL** ou un **VPS** (OVH, Hostinger, DigitalOcean, etc.) avec :
- PHP 8.1+
- MySQL
- Certificat SSL (Let's Encrypt recommandé)

### Étape 2 — Déployer les fichiers

**Option A — Git (recommandé)**

```bash
ssh user@serveur
cd /var/www/html
git clone <url-du-repo> dbdigitalagency
cd dbdigitalagency
composer install --no-dev --optimize-autoloader
```

**Option B — FTP/SFTP**

Transférez tous les fichiers **sauf** `.env` et `vendor/`, puis exécutez `composer install --no-dev` sur le serveur.

### Étape 3 — Fichier `.env` de production

```bash
cp .env.example .env
nano .env
```

Paramètres essentiels :

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dbdigitalagency.com

SEO_INDEX=true
```

> **Important :** `APP_URL` doit être l'URL publique exacte (avec `https://`). Elle sert au sitemap, aux balises canonical et hreflang.

### Étape 4 — Base de données

1. Créez une base MySQL via le panneau d'hébergement (ex. `dbdigitalagency`).
2. Créez un utilisateur MySQL dédié (évitez `root` en production).
3. Importez le schéma :

```bash
mysql -u VOTRE_USER -p VOTRE_BASE < database.sql
```

4. Renseignez les identifiants dans `.env`.

### Étape 5 — Permissions

```bash
chown -R www-data:www-data /chemin/vers/dbdigitalagency
chmod 755 uploads uploads/quotes
chmod 640 .env
```

Le serveur web (`www-data`, `apache` ou `nginx`) doit pouvoir **écrire** dans `uploads/quotes/`.

### Étape 6 — Virtual host

#### Apache

```apache
<VirtualHost *:443>
    ServerName dbdigitalagency.com
    ServerAlias www.dbdigitalagency.com
    DocumentRoot /var/www/html/dbdigitalagency

    <Directory /var/www/html/dbdigitalagency>
        AllowOverride All
        Require all granted
    </Directory>

    SSLEngine on
    # Certificats SSL…
</VirtualHost>
```

Redirection HTTP → HTTPS :

```apache
<VirtualHost *:80>
    ServerName dbdigitalagency.com
    Redirect permanent / https://dbdigitalagency.com/
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 443 ssl http2;
    server_name dbdigitalagency.com www.dbdigitalagency.com;
    root /var/www/html/dbdigitalagency;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.(env|git) {
        deny all;
    }

    location ^~ /uploads/ {
        location ~ \.php$ { deny all; }
    }
}
```

### Étape 7 — SMTP

Configurez un compte e-mail transactionnel (Gmail avec mot de passe d'application, Brevo, Mailgun, SMTP de l'hébergeur…) :

```env
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USERNAME=votre-compte@gmail.com
SMTP_PASSWORD=mot-de-passe-application
SMTP_ENCRYPTION=tls
SMTP_FROM_EMAIL=noreply@dbdigitalagency.com
SMTP_FROM_NAME="DB Digital Agency"
ADMIN_EMAIL=contact@dbdigitalagency.com
```

Testez l'envoi via le formulaire de contact après déploiement.

---

## Configuration `.env`

| Variable | Description |
|----------|-------------|
| `APP_ENV` | `production` ou `local` |
| `APP_DEBUG` | `false` en production |
| `APP_URL` | URL publique complète (`https://…`) |
| `CONTACT_*` | Adresse, téléphones, e-mail affichés sur le site |
| `WHATSAPP_NUMBER` | Numéro sans `+` ni espaces (ex. `237691323249`) |
| `DB_*` | Connexion MySQL |
| `SMTP_*` | Envoi des e-mails |
| `ADMIN_EMAIL` | Destinataire des notifications formulaires |
| `SEO_INDEX` | `true` = indexation Google, `false` = `noindex` (préprod) |
| `GOOGLE_MAPS_API_KEY` | Optionnel — active Google Maps au lieu de Leaflet |

Le modèle complet est dans [`.env.example`](.env.example).

---

## Base de données

Le fichier [`database.sql`](database.sql) crée les tables suivantes :

| Table | Usage |
|-------|-------|
| `quotes` | Demandes de devis |
| `quote_services` | Services sélectionnés (normalisation) |
| `quote_logs` | Journal envoi mail / WhatsApp |
| `contact_messages` | Messages du formulaire contact |
| `newsletter_subscribers` | Abonnés newsletter |
| `settings` | Paramètres optionnels (SMTP en base) |

Les formulaires **contact**, **devis** et **newsletter** nécessitent une base fonctionnelle. Le reste du site (pages vitrine) fonctionne sans base, mais les envois échoueront.

---

## Formulaires et e-mails

| Formulaire | Fichier de traitement | Stockage DB | E-mail |
|------------|----------------------|-------------|--------|
| Contact | `includes/process-contact.php` | `contact_messages` | Oui (PHPMailer) |
| Devis | `includes/process-quote.php` | `quotes` | Oui + pièce jointe brief |
| Newsletter | `includes/process-newsletter.php` | `newsletter_subscribers` | Non |

**Devis — upload de brief :**
- Formats acceptés : PDF, DOC, DOCX
- Taille max : 2 Mo
- Dossier : `uploads/quotes/` (créé automatiquement si permissions OK)

**Sécurité intégrée :**
- Token CSRF (session PHP)
- Champ honeypot anti-spam
- Validation et filtrage des entrées

---

## Cartes interactives

Les pages **Contact** et **Devis** affichent une carte des bureaux (Douala, Yaoundé, Bafoussam).

| Mode | Condition | Fournisseur |
|------|-----------|-------------|
| Par défaut | `GOOGLE_MAPS_API_KEY` vide | **Leaflet** + OpenStreetMap (aucune clé requise) |
| Optionnel | Clé renseignée dans `.env` | **Google Maps JavaScript API** |

Pour Google Maps en production :
1. Créer un projet sur [Google Cloud Console](https://console.cloud.google.com/)
2. Activer **Maps JavaScript API**
3. Restreindre la clé au domaine de production
4. Ajouter `GOOGLE_MAPS_API_KEY=…` dans `.env`

---

## SEO

- **Sitemap :** `https://votredomaine.com/sitemap.php`
- **Robots :** [`robots.txt`](robots.txt) pointe vers le sitemap
- **Canonical / hreflang :** générés dans `includes/head.php` à partir de `APP_URL`
- **Préproduction :** mettre `SEO_INDEX=false` pour éviter l'indexation

Après mise en ligne, soumettre le sitemap dans [Google Search Console](https://search.google.com/search-console).

---

## Sécurité et permissions

- Ne **jamais** committer `.env` ni `vendor/` (déjà dans `.gitignore`)
- `APP_DEBUG=false` en production
- Protéger `.env` au niveau serveur (refus d'accès HTTP)
- Interdire l'exécution de PHP dans `uploads/` (voir exemple Nginx ci-dessus)
- Utiliser **HTTPS** obligatoirement
- Préférer un **mot de passe d'application** SMTP plutôt que le mot de passe du compte

**Réseaux sociaux** — URLs configurées dans `includes/config.php` (`$social_links`).

**Contenus éditables sans base :**
- Textes i18n : `includes/lang/fr.php`, `includes/lang/en.php`
- Équipe : `components/team-section.php`
- Témoignages : `components/testimonial-section.php`
- Coordonnées des bureaux : `includes/config.php`

---

## Checklist post-déploiement

- [ ] `composer install --no-dev` exécuté sur le serveur
- [ ] `.env` configuré (`APP_URL`, `APP_DEBUG=false`, base, SMTP)
- [ ] Base importée (`database.sql`)
- [ ] Dossier `uploads/quotes/` créé et accessible en écriture
- [ ] HTTPS actif et redirection HTTP → HTTPS
- [ ] Formulaire contact testé (message reçu par e-mail + ligne en base)
- [ ] Formulaire devis testé (avec et sans pièce jointe)
- [ ] Newsletter testée
- [ ] Carte des 3 villes vérifiée (popups, pastilles)
- [ ] Switch FR/EN fonctionnel
- [ ] `sitemap.php` accessible
- [ ] Sitemap soumis à Google Search Console
- [ ] `SEO_INDEX=true` uniquement quand le site est prêt

---

## Dépannage

### « Database connection error »
- Vérifier `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` dans `.env`
- Confirmer que la base existe et que l'utilisateur a les droits

### Les e-mails ne partent pas
- Vérifier `SMTP_*` dans `.env`
- Tester avec un mot de passe d'application (Gmail) ou le SMTP de l'hébergeur
- Consulter les logs PHP du serveur (`error_log`)

### Erreur 500 après déploiement
- Vérifier que `vendor/` est installé (`composer install`)
- Vérifier les extensions PHP (`pdo_mysql`, `fileinfo`)
- Mettre temporairement `APP_DEBUG=true` **uniquement en préprod** pour diagnostiquer

### Upload de brief échoue
- Vérifier les permissions de `uploads/quotes/`
- Vérifier `upload_max_filesize` et `post_max_size` dans `php.ini` (≥ 2 Mo)

### Sitemap ou canonical incorrects
- `APP_URL` doit correspondre exactement à l'URL publique (`https://domaine.com`, sans slash final)

### Cache navigateur (CSS/JS)
- Les fichiers `custom.css` et `main.js` utilisent un cache-busting par `filemtime()` — un simple rechargement suffit après mise à jour

---

## Support technique

Pour toute évolution (nouvelle page, contenu, intégration), référez-vous aux composants dans `components/` et à la configuration centralisée dans `includes/config.php` et `includes/lang/`.
