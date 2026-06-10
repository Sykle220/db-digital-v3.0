# DB Digital Agency — CMS CodeIgniter 4

Site vitrine bilingue (FR/EN) avec back-office CMS, formulaires (contact, devis, newsletter), espace prospect et gestion SEO. Application **CodeIgniter 4** + **Shield** (authentification).

Ce guide est pensé pour un **déploiement simple sur hébergement mutualisé** (cPanel, Plesk, FTP) ainsi que pour un VPS.

---

## Sommaire

1. [Prérequis](#prérequis)
2. [Déploiement mutualisé (guide rapide)](#déploiement-mutualisé-guide-rapide)
3. [Installation locale](#installation-locale)
4. [Déploiement VPS / serveur dédié](#déploiement-vps--serveur-dédié)
5. [Configuration `.env`](#configuration-env)
6. [Base de données](#base-de-données)
7. [Assets et performance](#assets-et-performance)
8. [URLs et zones applicatives](#urls-et-zones-applicatives)
9. [Intégrations](#intégrations)
10. [Sécurité](#sécurité)
11. [Checklist post-déploiement](#checklist-post-déploiement)
12. [Dépannage](#dépannage)

---

## Prérequis

### Sur l'hébergeur (mutualisé)

| Composant | Requis |
|-----------|--------|
| PHP | **8.2+** |
| Extensions PHP | `intl`, `mbstring`, `json`, `mysqlnd`, `xml`, `curl`, `fileinfo`, `openssl` |
| MySQL / MariaDB | 5.7+ / 10.3+ |
| Apache | `mod_rewrite` activé (standard sur OVH, Hostinger, o2switch, PlanetHoster…) |
| SSL | Let's Encrypt via le panneau hébergeur |

**Non requis sur le serveur :** Composer, Node.js, Git, SSH (tout peut être préparé sur votre ordinateur).

### Sur votre ordinateur (préparation)

| Outil | Usage |
|-------|--------|
| Composer 2.x | Installer les dépendances PHP (`vendor/`) |
| Node.js 18+ | Optionnel — minifier les assets avant envoi |

---

## Déploiement mutualisé (guide rapide)

Procédure type **cPanel / FTP**, sans compétences serveur. Durée estimée : **20 à 30 minutes**.

### Vue d'ensemble

```
Sur votre PC                    Sur l'hébergeur (cPanel)
─────────────                   ───────────────────────
composer install --no-dev  →    1. Créer base MySQL
cp .env.example .env            2. Uploader le ZIP (FTP)
php spark key:generate          3. Éditer .env
import dbdigitalagency.sql →    4. Importer BDD (phpMyAdmin)
  ou migrate + seed               ou Terminal : spark migrate
php spark assets:build            5. Permissions 755
ZIP + upload                      6. Tester /fr et /admin
```

### Étape 1 — Préparer le site sur votre ordinateur

```bash
git clone <url-du-repo> dbdigitalagency
cd dbdigitalagency
composer install --no-dev --optimize-autoloader
cp .env.example .env
php spark key:generate
```

Éditez `.env` avec les identifiants MySQL **fournis par votre hébergeur** (voir panneau « Bases de données ») :

```env
CI_ENVIRONMENT = production
app.baseURL = 'https://votredomaine.com/'
app.indexPage = ''
APP_DEBUG = false
APP_URL = 'https://votredomaine.com'

database.default.hostname = localhost
database.default.database = cpanel_prefix_db
database.default.username = cpanel_prefix_user
database.default.password = 'mot_de_passe_hebergeur'
```

> **Hôte MySQL :** souvent `localhost` sur mutualisé. Si la connexion échoue, recopiez l'hôte exact affiché dans cPanel (ex. `mysql.monhebergeur.com`).

Initialisez la base **depuis votre PC** (si MySQL distant autorisé) **ou** importez directement le dump fourni :

**Option A — Migrations + seed (développement, base vide)**

```bash
php spark migrate --all
php spark db:seed
```

**Option B — Import du dump complet** (recommandé pour un déploiement rapide, schéma + données inclus) :

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS dbdigitalagency CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
mysql -u root -p dbdigitalagency < dbdigitalagency.sql
```

> Ne pas exécuter `migrate` + `seed` après l'import de `dbdigitalagency.sql` — le dump contient déjà tout le schéma et le contenu initial.

**Optionnel — assets minifiés** (recommandé, sans Node.js sur le serveur) :

```bash
php spark assets:build
# puis dans .env : ASSETS_MINIFIED = true
```

Créez une archive ZIP du projet **en incluant** `vendor/` et `assets/build/` (s'ils existent). **N'incluez pas** `.env` dans le ZIP public — créez-le directement sur le serveur.

### Étape 2 — Créer la base MySQL (cPanel)

1. **Bases de données MySQL** → créer une base (ex. `monsite_db`)
2. Créer un utilisateur et l'associer à la base (**tous les privilèges**)
3. Noter : nom de la base, utilisateur, mot de passe, hôte

### Étape 3 — Envoyer les fichiers (FTP / Gestionnaire de fichiers)

**Cas le plus courant — domaine à la racine (`public_html/`)**

1. Connectez-vous en FTP ou ouvrez le **Gestionnaire de fichiers** cPanel
2. Allez dans `public_html/`
3. Uploadez et extrayez le ZIP (le `.htaccess` à la racine du projet doit se retrouver dans `public_html/.htaccess`)
4. Structure attendue :

```
public_html/
├── .htaccess          ← routage Apache (fourni)
├── app/
├── public/
├── assets/
├── vendor/            ← obligatoire (généré par Composer)
├── writable/
├── uploads/
├── spark
└── composer.json
```

**Sous-dossier** (ex. `public_html/mon-site/`) : même principe, avec  
`app.baseURL = 'https://votredomaine.com/mon-site/'`

**Document root = `public/`** (option avancée cPanel) : pointez le domaine vers le dossier `public/`. Les liens symboliques `public/assets` et `public/uploads` sont déjà prévus dans le dépôt.

### Étape 4 — Fichier `.env` sur le serveur

1. Copiez `.env.example` → `.env` via le Gestionnaire de fichiers
2. Collez la **clé de chiffrement** générée sur votre PC (`encryption.key = …` dans votre `.env` local)
3. Vérifiez `app.baseURL`, la base MySQL et le SMTP

### Étape 5 — Base de données sur l'hébergeur

**Méthode A — Import du dump `dbdigitalagency.sql`** (recommandé, sans Terminal)

1. Créez une base MySQL vide dans cPanel (étape 2)
2. cPanel → **phpMyAdmin** → sélectionnez la base → **Importer**
3. Choisissez le fichier `dbdigitalagency.sql` (à la racine du projet) → **Exécuter**
4. Vérifiez que les identifiants MySQL dans `.env` correspondent à la base importée

> Le fichier `dbdigitalagency.sql` contient le schéma complet (migrations appliquées) et les données initiales (contenu CMS, admin, traductions). **Ne pas** relancer `migrate` ni `seed` après cet import.

**Méthode B — Terminal cPanel / SSH**

```bash
cd ~/public_html
php spark migrate --all
php spark db:seed
```

**Méthode C — phpMyAdmin avec export personnalisé**

1. Sur votre PC, après `migrate` + `seed`, exportez la base :
   ```bash
   mysqldump -u root dbdigitalagency > install.sql
   ```
2. cPanel → **phpMyAdmin** → sélectionnez la base → **Importer** → `install.sql`

### Étape 6 — Permissions (cPanel)

Via Gestionnaire de fichiers → clic droit → **Autorisations** :

| Dossier | Permission |
|---------|------------|
| `writable/` | **755** (ou 775 si erreurs d'écriture) |
| `writable/cache/` | 755 |
| `writable/logs/` | 755 |
| `writable/session/` | 755 |
| `uploads/` | 755 |

### Étape 7 — SSL et test

1. Activez le certificat SSL (Let's Encrypt) dans cPanel
2. Forcez HTTPS (option « Toujours utiliser HTTPS » dans cPanel)
3. Testez :
   - `https://votredomaine.com/fr` — accueil
   - `https://votredomaine.com/admin` — back-office (redirige vers `/login`)
   - `https://votredomaine.com/sitemap.xml`

### Étape 8 — Configuration via l'admin (sans toucher au code)

Connectez-vous à `/admin` et configurez dans le panneau :

| Réglage | Où |
|---------|-----|
| SMTP, e-mails | Admin → Paramètres |
| reCAPTCHA (site + secret) | Admin → Intégrations |
| Google Maps, tracking | Admin → Intégrations |
| TinyMCE | Admin → Intégrations |
| Logo, favicon | Admin → Branding |

Identifiants initiaux : `ADMIN_SEED_EMAIL` / `ADMIN_SEED_PASSWORD` dans `.env` (changez le mot de passe après la première connexion).

### Ce qui fonctionne sans SSH sur mutualisé

| Besoin | Solution |
|--------|----------|
| Dépendances PHP | `composer install` sur votre PC → uploader `vendor/` |
| Clé de chiffrement | `php spark key:generate` sur PC → copier dans `.env` serveur |
| Schéma BDD | Import `dbdigitalagency.sql` via phpMyAdmin **ou** Terminal cPanel |
| Assets minifiés | `php spark assets:build` sur PC → uploader `assets/build/` |
| Contenu, SEO, médias | 100 % via `/admin` après installation |

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

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/dbdigitalagency/public/'
database.default.hostname = localhost
database.default.database = dbdigitalagency
database.default.username = root
database.default.password =
```

### 3. Base de données

Créez d'abord la base (si elle n'existe pas) :

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS dbdigitalagency CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
```

**Option A — Import direct** (le plus rapide) :

```bash
mysql -u root -p dbdigitalagency < dbdigitalagency.sql
```

**Option B — Migrations + seed** (base vide, développement) :

```bash
php spark migrate --all
php spark db:seed
```

> Utilisez l'une ou l'autre méthode, pas les deux. Voir [Base de données](#base-de-données) pour le détail.

### 4. Serveur local

```bash
sudo ./scripts/setup-apache.sh   # Apache + mod_rewrite
# ou
php spark serve                  # http://localhost:8080/fr
```

---

## Déploiement VPS / serveur dédié

Pour un VPS avec accès root (DigitalOcean, OVH VPS, etc.) :

```bash
git clone <url-du-repo> /var/www/html/dbdigitalagency
cd /var/www/html/dbdigitalagency
composer install --no-dev --optimize-autoloader
cp .env.example .env && php spark key:generate
# Éditer .env (production)
# Base : import du dump OU migrations + seed (voir section Base de données)
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS dbdigitalagency CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
mysql -u root -p dbdigitalagency < dbdigitalagency.sql
# ou : php spark migrate --all && php spark db:seed
php spark assets:build
sudo ./scripts/fix-writable-perms.sh
sudo ./scripts/setup-apache.sh
```

**Virtual host Apache** (DocumentRoot = racine du projet) :

```apache
<VirtualHost *:443>
    ServerName dbdigitalagency.com
    DocumentRoot /var/www/html/dbdigitalagency
    <Directory /var/www/html/dbdigitalagency>
        AllowOverride All
        Require all granted
        FallbackResource public/index.php
    </Directory>
    SSLEngine on
</VirtualHost>
```

Voir [`scripts/apache-dbdigitalagency.conf`](scripts/apache-dbdigitalagency.conf) pour la configuration complète.

---

## Configuration `.env`

| Variable | Description |
|----------|-------------|
| `CI_ENVIRONMENT` | `production` en prod |
| `app.baseURL` | URL publique avec slash final (`https://domaine.com/`) |
| `app.indexPage` | Laisser vide (`''`) |
| `encryption.key` | Généré par `php spark key:generate` |
| `database.default.*` | Connexion MySQL (valeurs cPanel) |
| `APP_URL` | Même URL que `app.baseURL` (sans slash final possible) |
| `APP_DEBUG` | `false` en production |
| `SMTP_*` | Envoi des e-mails |
| `SEO_INDEX` | `true` en prod ; `false` en préprod |
| `ASSETS_MINIFIED` | `true` si `assets/build/` est présent |
| `ADMIN_SEED_*` | Compte admin initial (seeder) |

Modèle complet : [`.env.example`](.env.example).

### Exemples `app.baseURL`

| Installation | `app.baseURL` |
|--------------|---------------|
| Domaine racine | `'https://dbdigitalagency.com/'` |
| Sous-dossier | `'https://dbdigitalagency.com/mon-site/'` |
| Local Apache | `'http://localhost/dbdigitalagency/public/'` |
| `php spark serve` | `'http://localhost:8080/'` |

---

## Base de données

Deux approches équivalentes pour une installation initiale :

| Approche | Quand l'utiliser |
|----------|------------------|
| **Import `dbdigitalagency.sql`** | Déploiement rapide (mutualisé, prod, démo) — schéma + données en une fois |
| **`migrate` + `seed`** | Développement, base vide, ou mise à jour incrémentale du schéma |

### Import direct — `dbdigitalagency.sql`

Fichier à la racine du dépôt : dump MySQL complet (structure + données) généré depuis l'environnement de référence. Il inclut notamment :

- Toutes les tables CMS (pages, blog, services, équipe, SEO, etc.)
- Le contenu initial et les traductions FR/EN
- Le compte administrateur Shield (`admin@dbdigitalagency.com`)

**Prérequis :** une base MySQL vide, nommée comme dans `.env` (`database.default.database`).

**Ligne de commande :**

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS dbdigitalagency CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
mysql -u root -p dbdigitalagency < dbdigitalagency.sql
```

**phpMyAdmin (mutualisé) :**

1. Créer la base dans cPanel
2. Sélectionner la base → **Importer** → choisir `dbdigitalagency.sql` → **Exécuter**

**Important :**

- Ne pas exécuter `php spark migrate` ni `php spark db:seed` après l'import (risque de doublons ou d'erreurs)
- Adapter `database.default.*` dans `.env` au nom de base et aux identifiants de l'hébergeur
- Changer le mot de passe admin après la première connexion (`/admin`)
- Le dump ne contient pas de `CREATE DATABASE` : la base doit exister avant l'import

### Migrations et seeders (alternative)

| Commande | Usage |
|----------|-------|
| `php spark migrate --all` | Applique les migrations (schéma vide) |
| `php spark db:seed` | Contenu initial + admin |
| `php spark db:seed AdminUserSeeder` | Réinitialiser le compte admin |

Identifiants admin créés par le seeder : `ADMIN_SEED_EMAIL` / `ADMIN_SEED_PASSWORD` dans `.env`.

> `database.sql` à la racine est **legacy** (ancien schéma). Utiliser **`dbdigitalagency.sql`** pour un import complet, ou les migrations CI4 pour une installation from scratch.

---

## Assets et performance

| Mode | Action |
|------|--------|
| Mutualisé sans Node | Build sur PC : `php spark assets:build` → uploader `assets/build/` |
| Avec Terminal | `php spark assets:build` sur le serveur |
| Sans minification | `ASSETS_MINIFIED = false` (les CSS/JS sources fonctionnent) |

Activer les minifiés : **Admin → Intégrations** ou `ASSETS_MINIFIED=true`.

---

## URLs et zones applicatives

Avec `app.baseURL = 'https://dbdigitalagency.com/'` :

| Zone | URL |
|------|-----|
| Accueil FR / EN | `/fr` · `/en` |
| Contact / Devis | `/fr/contact` · `/fr/devis` |
| Sitemap | `/sitemap.xml` |
| Login admin | `/login` |
| Back-office | `/admin` |
| Espace prospect | `/prospect/access/{token}` |

Les anciennes URLs (`contact.php`, `get-quote.php`…) redirigent en 301 via `.htaccess`.

---

## Intégrations

| Service | Configuration |
|---------|---------------|
| E-mails | `.env` (`SMTP_*`) + Admin → Paramètres |
| reCAPTCHA v3 | Site Key + Secret Key dans **Admin → Intégrations** |
| Google Maps | Admin → Intégrations (sinon Leaflet / OpenStreetMap) |
| Tracking (GA, GTM…) | Admin → Intégrations |
| TinyMCE | Admin → Intégrations |

---

## Sécurité

Le `.htaccess` racine **bloque l'accès HTTP** à :

- `.env`, `composer.json`, `spark`
- dossiers `app/`, `vendor/`, `writable/`

Bonnes pratiques mutualisé :

- Ne jamais exposer `.env` ni `vendor/` (ne pas les placer dans un dossier public sans protection)
- `CI_ENVIRONMENT=production` et `APP_DEBUG=false`
- HTTPS obligatoire
- `uploads/` : exécution PHP interdite (`.htaccess` fourni)
- Changer `ADMIN_SEED_PASSWORD` après la première connexion
- Mot de passe d'application SMTP (Gmail, Brevo…)

---

## Checklist post-déploiement

- [ ] `vendor/` présent sur le serveur
- [ ] `.env` configuré (`app.baseURL`, base MySQL, SMTP, `encryption.key`)
- [ ] Base initialisée (`dbdigitalagency.sql` importé **ou** migrations + seed)
- [ ] Permissions `writable/` et `uploads/` (755)
- [ ] HTTPS actif
- [ ] `https://domaine.com/fr` s'affiche correctement
- [ ] CSS/JS chargés (pas de page « nue »)
- [ ] `/admin` accessible, mot de passe admin changé
- [ ] Formulaire contact testé (e-mail reçu)
- [ ] Formulaire devis testé
- [ ] `/sitemap.xml` accessible
- [ ] `SEO_INDEX=true` quand le site est prêt

---

## Dépannage

### Page blanche ou erreur 500

- Vérifier que `vendor/` est uploadé
- Vérifier PHP **8.2+** et extensions (`intl`, `mbstring`, `mysqlnd`)
- Consulter `writable/logs/log-*.log` (via FTP)
- Vérifier que `encryption.key` est renseigné dans `.env`

### Erreur 404 sur toutes les pages

- Vérifier que `public_html/.htaccess` est bien présent (fichiers cachés visibles dans cPanel)
- Vérifier que `mod_rewrite` est actif (support hébergeur)
- Vérifier `app.baseURL` (URL exacte avec `https://`)

### CSS / JS absents (page sans style)

- Vérifier que le dossier `assets/` est uploadé
- Si DocumentRoot = `public/` : vérifier les liens `public/assets` → `../assets`
- Vérifier `app.baseURL` (pas de `/public/` si la racine du projet est le DocumentRoot)

### Erreur de connexion MySQL

- Recopier hôte, base, utilisateur et mot de passe depuis cPanel
- Sur mutualisé, le préfixe utilisateur compte souvent (ex. `user123_db`)

### Erreur d'écriture (uploads, cache, sessions)

- Passer `writable/` et `uploads/` en **755** ou **775**
- Vérifier que les sous-dossiers `writable/cache`, `writable/logs`, `writable/session` existent

### Les e-mails ne partent pas

- Configurer SMTP dans `.env` ou Admin → Paramètres
- Utiliser le SMTP de l'hébergeur ou Brevo / Gmail (mot de passe d'application)

### `php spark` inaccessible sur mutualisé

- Utiliser le **Terminal cPanel** (chemin : `~/public_html`)
- Sinon : importer `dbdigitalagency.sql` via **phpMyAdmin** (voir [Base de données](#base-de-données))
- Les mises à jour de contenu se font via `/admin` sans CLI

---

## Commandes utiles

```bash
# Base : import dump OU migrations + seed
mysql -u root -p dbdigitalagency < dbdigitalagency.sql
php spark migrate --all
php spark db:seed

php spark assets:build
php spark key:generate
php spark routes
```

---

## Support

| Besoin | Où |
|--------|-----|
| Contenu, pages, blog | `/admin` |
| Traductions | Admin → Traductions |
| Logo, favicon | Admin → Branding |
| SEO, redirections | Admin → SEO |
| SMTP, reCAPTCHA, tracking | Admin → Intégrations |

Structure technique : `app/`, migrations dans `app/Database/Migrations/`.
