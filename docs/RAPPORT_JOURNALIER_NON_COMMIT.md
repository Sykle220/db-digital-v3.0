# Rapport journalier — Travail non commité

**Date du rapport :** 9 juin 2026  
**Projet :** DB Digital Agency — migration CMS CodeIgniter 4  
**Référence Git :** dernier commit `61d3582` (8 juin 2026, 14h16)  
**État dépôt :** 37 suppressions · 16 modifications · ~500+ fichiers non suivis

---

## 1. Synthèse

L’ensemble du travail en cours correspond à la **migration complète** du site PHP natif vers **CodeIgniter 4 + Shield**, avec back-office CMS, front bilingue, espace prospect et chaîne de déploiement Apache/assets. **Aucun de ces changements n’est encore commité.**

| Indicateur | Valeur |
|------------|--------|
| Fichiers PHP `app/` | ~243 |
| Contrôleurs admin | 23 |
| Contrôleurs front | 13 |
| Migrations SQL | 11 |
| Seeders | 13 |
| Delta Git (tracked) | +11 418 / −6 146 lignes |

---

## 2. Tâches réalisées (non commitées)

### 2.1 Architecture et routing

- Initialisation **CI4** (`app/`, `public/`, `spark`, `preload.php`, `writable/`).
- `index.php` racine délègue au front controller `public/index.php`.
- **`.htaccess`** : redirections 301 des anciennes URLs (`about.php`, `contact.php`, `get-quote.php`, etc.) vers routes `/fr/…` · `/en/…`.
- Routes localisées FR/EN (accueil, services, projets, blog, contact, devis, pages ville).
- **Sitemap** dynamique via `SitemapController`.

### 2.2 Suppression / remplacement du legacy

- Anciens fichiers racine et dossiers **`components/`**, **`includes/`** marqués supprimés (37 fichiers).
- Logique reprise dans `app/Views/front/`, services PHP et seeders (données migrées depuis l’ancienne config).

### 2.3 Back-office CMS (`/admin`)

Modules CRUD ou gestion :

| Module | Fonction |
|--------|----------|
| Pages, Homepage | Contenu éditorial |
| Services, Projets, Blog | Offre et portfolio |
| Équipe, Témoignages, Brand logos | Social proof |
| Bureaux (Offices) | Implantations + carte |
| Menus, Traductions | Navigation i18n |
| Médias | Bibliothèque + picker |
| Branding, Settings, Integrations | Identité, SMTP, reCAPTCHA, tracking |
| SEO | Meta, redirections, sitemap |
| Devis, Contacts, Newsletter | Leads et abonnés |
| Utilisateurs, Profil | Shield + rôles admin |

Authentification **CodeIgniter Shield** ; filtres `admin`, `csrf`, `prospect`.

### 2.4 Front public

- Vues : `home`, `about`, `services` (+ détail), `projects`, `blog`, `contact`, `quote`, `page`, erreurs.
- Partials : cartes, carte Google Maps, chips villes, témoignages, marques, consentement cookies, tracking.
- Formulaires contact / devis / newsletter branchés sur controllers + services (`MailService`, `QuoteService`).
- **reCAPTCHA v3** optionnel (Admin → Intégrations + `.env`).
- Bannière **cookies** + scripts `site-consent.js`, `site-tracking.js`.

### 2.5 Espace prospect

- Connexion par **lien magique** (`/user/login`, `/prospect/access/{token}`).
- Dashboard : téléchargement brief, upload documents complémentaires.
- Lien renvoyable depuis l’admin devis.

### 2.6 Base de données

- **11 migrations** : tables legacy formulaires, CMS core, contenu, settings, logs admin, documents devis, blog, branding admin, intégrations, assets minifiés, TinyMCE.
- **13 seeders** : contenu initial, admin, SEO, menus, branding, médias.
- `database.sql` annoté **LEGACY ONLY** — schéma CMS via `php spark migrate --all`.

### 2.7 Assets et performance

- Pipeline **npm** : `package.json`, `scripts/build-assets.mjs`, commande `php spark assets:build`.
- Sortie minifiée : `assets/build/` + flag `ASSETS_MINIFIED`.
- Nouveaux JS : `locations-map.js`, `recaptcha-forms.js` ; CSS `admin.css`, `prospect.css`.

### 2.8 Configuration et ops

- **`.env.example`** étendu : CI4, encryption key, DB, email, intégrations, seed admin, CDN, assets minifiés.
- **README** mis à jour : Apache (`setup-apache.sh`), `php spark serve`, FallbackResource.
- Scripts : `setup-apache.sh`, `fix-writable-perms.sh`, `apache-dbdigitalagency.conf`, cache assets.
- **Composer** : PHP 8.2, CI4 ^4.7, Shield ^1.1 (+ lock vendor non commité).

---

## 3. Fichiers clés modifiés (tracked, non commités)

```
.env.example · .gitignore · README.md · composer.json · database.sql
index.php · assets/css/custom.css · assets/js/ajax-form.js
vendor/* (autoload + dépendances CI4)
+ 37 suppressions (ancien site PHP natif)
```

---

## 4. Points d’attention avant commit

| Point | Action recommandée |
|-------|-------------------|
| `.env` / secrets | Ne pas committer ; vérifier `.gitignore` |
| `vendor/` | Décider : commit ou `composer install` en CI |
| `writable/` | Exclu du dépôt ; permissions serveur |
| Tests manuels | Parcours FR/EN, formulaires, admin, prospect |
| Migrations prod | `spark migrate` + seeders sur environnement cible |
| Anciennes URLs | Valider redirections 301 en prod |
| Rapports docs | Anciens rapports supprimés localement — archiver si besoin |

---

## 5. Prochaines étapes suggérées

1. Recette complète locale (Apache + MySQL + migrate + seed).
2. Commit structuré : *(1)* infra CI4, *(2)* app + migrations, *(3)* assets/build, *(4)* docs.
3. Générer `encryption.key` et changer mot de passe seed admin.
4. Configurer reCAPTCHA / Google Maps en intégrations admin.
5. Déploiement staging avant bascule DNS prod.

---

## 6. Résumé exécutif

Le dépôt contient une **refonte majeure non versionnée** : passage d’un site PHP monolithique à un **CMS CI4 administrable**, avec conservation SEO (redirections, sitemap), formulaires sécurisés, espace client devis et outillage déploiement. Le travail est **fonctionnellement avancé** mais **non stabilisé en Git** — commit et tests de bout en bout sont la priorité immédiate.

---

*Rapport généré à partir de `git status` et analyse du working tree — aucun commit au-delà de `61d3582`.*
