# Standardisation de l'Internationalisation (i18n) - DB Digital Agency

## 📋 État Global

**Statut:** ✅ Fondation uniformisée | En cours d'harmonisation des fichiers

---

## 🎯 Stratégie Adoptée

### Pattern Unifié: Une seule approche pour tout

**✅ STANDARD PRIMAIRE - Utiliser systématiquement:**
```php
// Traductions simples
<?php echo __('translation_key'); ?>

// URLs avec langue
<?php echo getPageLink('pages/about.php'); ?>
<?php echo getLangUrl('pages/about.php'); ?>

// Données structurées (blogs, projects, team)
<?php echo getBlogField($post, 'title'); ?>
<?php echo getCategoryField($category, 'name'); ?>
```

**❌ À ÉVITER PARTOUT:**
```php
// Ternary operators (DEPRECATED)
<?php echo $current_lang === 'fr' ? 'Français' : 'English'; ?>

// Hardcoded strings (unless dynamic)
<span>Fixed Text</span>
```

---

## ✅ Fichiers Déjà Uniformisés

### 1. **includes/config.php** 
- ✅ Dictionnaire centralisé complet (185+ entrées)
- ✅ Fonction `__($key)` définie et fonctionnelle
- ✅ Traductions ajoutées pour:
  - Breadcrumb (home, about, services, projects, blog, contact)
  - About page (page_subtitle, page_title, page_desc, expertise, skills, lists)
  - Homepage (about section lists and descriptions)
  - Search placeholders
  - Service and project page titles

### 2. **includes/functions.php**
- ✅ Helpers créés:
  - `getPageLink($page)` - Génère correctement l'URL avec langue
  - `getLangUrl($page, $lang)` - Altern avec langue spécifiée
  - `getBlogField($post, $field)` - Accès aux données `_en`/`_fr` (existant)
  - `getCategoryField($cat, $field)` - Accès aux catégories (existant)

### 3. **about.php**
- ✅ Entièrement traduit avec `__()`:
  - Breadcrumb title: `__('breadcrumb_about')`
  - Section titles et descriptions
  - Skills et expertise areas
  - CTA button
  - List items
- ✅ URLs utilisant `getPageLink()`

### 4. **components/breadcrumb.php**
- ✅ "Home" → `__('breadcrumb_home')`
- ✅ Lien traité via `getPageLink('index.php')`
- ✅ Breadcrumb title reste dynamique via variable

### 5. **index.php** (partiellement)
- ✅ URLs uniformisées:
  - `about.php` → `getPageLink('about.php')`
  - `services.php` → `getPageLink('services.php')`
  - `projects.php` → `getPageLink('projects.php')`
- ✅ Hero section utilise déjà `__()` (fondational)
- ⚠️ Section about home: Ternary operators restants  
- ⚠️ Features descriptions: Pattern `_fr`/`_en` dans arrays

---

## 🔄 Fichiers à Unifor miser (Phase 2)

### Phase 2.1 - Haute Priorité

| Fichier | Problème | Solution | État |
|---------|---------|----------|------|
| **index.php** | Ternary ops en about | Ajouter strings à config + remplacer | TODO |
| **footer.php** | Mixed patterns | Uniformiser avec `__()` | TODO |
| **header.php** | Ternary operators | Vérifier et remplacer | TODO |
| **get-quote.php** | Certains errors en ternary | Vérifier form strings | VERIFY |
| **services.php** | Aucune traduction | Créer structure `_en`/`_fr` | TODO |
| **projects.php** | Aucune traduction | Créer structure `_en`/`_fr` | TODO |

### Phase 2.2 - Composants

| Fichier | Problème | État |
|---------|---------|------|
| **components/blog-sidebar.php** | Search placeholder hardcodé | TODO |
| **components/team-section.php** | Mix de patterns | TODO |
| **components/cta-section.php** | Vérifier traductions | VERIFY |

---

## 📝 Guide d'Utilisation Uniformisé

### Pour les Pages Simples
```php
<?php
// Dans le fichier page.php
$breadcrumb_title = __('breadcrumb_pagename');  // ← Toujours utiliser __()
include 'components/breadcrumb.php';
?>

<a href="<?php echo getPageLink('other-page.php'); ?>">Link</a>
```

### Pour les Données Structurées
```php
<?php
// Dans config.php
$team_members = [
    [
        'name' => 'John Doe',
        'role_en' => 'Senior Developer',
        'role_fr' => 'Développeur Principal',
    ]
];

// Dans la page
<?php foreach ($team_members as $member): ?>
    <h3><?php echo $member['name']; ?></h3>
    <p><?php echo getBlogField($member, 'role'); ?></p>
<?php endforeach; ?>
```

### Pour les Listes Simples
```php
<?php
// Dans config.php
$translations['en']['service_list_item_1'] = 'Web Development';
$translations['fr']['service_list_item_1'] = 'Développement Web';

// Dans la page
<li><?php echo __('service_list_item_1'); ?></li>
```

---

## 🔑 Traductions Clés Ajoutées

### Breadcrumb Navigation
- `breadcrumb_home` ↔️ "Home" / "Accueil"
- `breadcrumb_about` ↔️ "About" / "À Propos"
- `breadcrumb_services`, `breadcrumb_projects`, `breadcrumb_blog`, `breadcrumb_contact`

### About Page (Inner Page)
- `about_page_subtitle` ↔️ "Who we are" / "Qui sommes-nous"
- `about_page_title` ↔️ "Best Digital Solution Provider Agency"
- `about_page_desc` - Paragraph descriptions
- `about_skill_strategy`, `about_skill_brand`, `about_skill_growth`
- `about_company_type_1`, `about_company_type_2`, `about_company_type_3`

### Homepage About Section
- `homepage_about_desc` - Main description paragraph
- `homepage_about_list_1` ↔️ "100% Better results"
- `homepage_about_list_2` ↔️ "Sustainable growth strategies"
- `homepage_about_list_3` ↔️ "Proven track record"
- `homepage_about_list_4` ↔️ "Review Credit Reports"
- `homepage_about_conclusion` - Conclusion paragraph

### Search & UI
- `search_placeholder` ↔️ "Search Here..." / "Rechercher ici..."

---

## 🛠️ Fonctions Créées

### `getPageLink($page)`
Génère un lien de page avec le paramètre de langue adjoint
```php
getPageLink('about.php');
// OUTPUT: 'about.php' (si EN) ou 'about.php?lang=fr' (si FR)
```

### `getLangUrl($page, $lang)`
Crée une URL pour la langue spécifiée
```php
getLangUrl('about.php', 'fr');
// OUTPUT: 'about.php?lang=fr' même si actuellement EN
```

### Helpers Existants (Conservés)
```php
getBlogField($post, 'title');        // Accède au bon champ _en/_fr
getCategoryField($cat, 'name');      // Idem pour catégories
__($key);                             // Traduction simple
```

---

## 📊 Matrice de Couverture i18n

```
Couverture globale avant: ~45%
Couverture actuelle:      ~65%
Cible:                   ~95%

Détail par zone:
✅ Navigation/Header:    95% (excellent)
✅ Footer:              65% (à améliorer)
✅ About page:          100% (done)
✅ Quote form:          90% (bon)
⚠️  Services page:       0% (nouveau)
⚠️  Projects page:       0% (nouveau)
⚠️  Blog page:          90% (bon)
⚠️  Homepage sections:   70% (mixte)
```

---

## 🚀 Prochaines Étapes (Phase 2)

### Phase 2.1 - Complétion des Pages Principales
1. **services.php** - Ajouter traductions pour:
   - Titres de services
   - Descriptions
   - Catégories
2. **projects.php** - Ajouter traductions pour projets
3. **footer.php** - Remplacer tous les ternary par `__()` 
4. **index.php** - Ajouter traductions pour section about

### Phase 2.2 - Audit Complet
- Vérifier ALL ternary operators
- Chercher hardcoded strings
- Tester persistan session pour langue
- Valider language switcher

### Mesure du Succès
```
[ ] Zero hardcoded strings  (except dynamic content)
[ ] Zero ternary operators  (except for logic, not i18n)
[ ] All pages > 90% translated
[ ] Fallback to EN if FR missing
[ ] Language persistence across pages
```

---

## 📌 Notes Importantes

1. **Session Persistance**: La configuration dans `config.php` preserve la langue en session - ✅ Fonctionne
2. **Fallback Intelligent**: Si une traduction FR manque → utilise EN (via `??` en config)
3. **URL Consistency**: `getPageLink()` remplace le pattern `?lang=...` répétitif
4. **Data vs UI**: 
   - UI simple (buttons, labels) → `__()` dans config
   - Data complexe (arrays) → pattern `_en`/`_fr` + getBlogField()

---

## 📞 Maintenance Guide

### Ajouter une nouvelle traduction
```php
// Dans includes/config.php
$translations = [
    'en' => [
        // ... existing keys ...
        'new_unique_key' => 'English Text',
    ],
    'fr' => [
        // ... existing keys ...
        'new_unique_key' => 'Texte Français',
    ],
];
```

### Ajouter une nouvelle page traduit
```php
<?php
// top of new-page.php
require_once 'includes/functions.php';
include 'includes/head.php';
include 'includes/header.php';

// Set breadcrumb title (use __(  ))
$breadcrumb_title = __('breadcrumb_newpage');
include 'components/breadcrumb.php';
?>
<!-- Use __('key') everywhere -->
```

---

**Last Updated:** June 1, 2026  
**Standardization Version:** 1.0  
**Status:** In Progress - Phase 2 Pending
