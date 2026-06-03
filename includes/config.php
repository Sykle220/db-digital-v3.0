<?php
// includes/config.php

define('SITE_NAME', 'DB Digital Agency');

// URL absolue (SEO, sitemap). Ex: https://dbdigitalagency.com
define('SITE_URL', rtrim((string) envv('APP_URL', ''), '/'));

// Paths relatifs (assets) pour éviter les 404 selon sous-dossier/virtualhost
define('BASE_URL', ''); // conservé pour compat, laisser vide
define('ASSETS_URL', 'assets/');

define('APP_ENV', (string) envv('APP_ENV', 'production'));
define('APP_DEBUG', env_bool('APP_DEBUG', false));

// Navigation principale
$nav_items = [
    ['url' => 'index.php', 'label_key' => 'nav_home', 'class' => ''],
    ['url' => 'about.php', 'label_key' => 'nav_about', 'class' => ''],
    ['url' => 'services.php', 'label_key' => 'nav_services', 'class' => ''],
    ['url' => 'projects.php', 'label_key' => 'nav_projects', 'class' => ''],
    ['url' => 'blog.php', 'label_key' => 'nav_blog', 'class' => ''],
    ['url' => 'contact.php', 'label_key' => 'nav_contact', 'class' => ''],
];

// Coordonnées
define('CONTACT_ADDRESS', (string) envv('CONTACT_ADDRESS', 'Entrée Carriere, Nkoabang, Yaoundé, Cameroon'));
define('CONTACT_PHONE_1', (string) envv('CONTACT_PHONE_1', '+237 691 323 249'));
define('CONTACT_PHONE_2', (string) envv('CONTACT_PHONE_2', '+237 658 910 343'));
define('CONTACT_PHONE_3', (string) envv('CONTACT_PHONE_3', '+237 640 819 846'));
define('CONTACT_EMAIL', (string) envv('CONTACT_EMAIL', 'contact@dbdigitalagency.com'));

// WhatsApp (numéro sans espaces pour l'URL)
define('WHATSAPP_NUMBER', (string) envv('WHATSAPP_NUMBER', '237691323249'));

// Réseaux sociaux
$social_links = [
    'facebook'  => '#',
    'twitter'   => '#',
    'instagram' => '#',
    'linkedin'  => '#',
];

// La gestion de langue (session + $current_lang) est centralisée dans includes/functions.php

// ============================================
// CONFIGURATION BASE DE DONNÉES
// ============================================
define('DB_HOST', (string) envv('DB_HOST', 'localhost'));
define('DB_NAME', (string) envv('DB_NAME', 'dbdigitalagency'));
define('DB_USER', (string) envv('DB_USER', 'root'));
define('DB_PASS', (string) envv('DB_PASS', ''));
define('DB_CHARSET', 'utf8mb4');

// ============================================
// CONFIGURATION EMAIL / SMTP
// ============================================
define('SMTP_HOST', (string) envv('SMTP_HOST', 'smtp.gmail.com'));
define('SMTP_PORT', env_int('SMTP_PORT', 587));
define('SMTP_USERNAME', (string) envv('SMTP_USERNAME', ''));
define('SMTP_PASSWORD', (string) envv('SMTP_PASSWORD', ''));
define('SMTP_ENCRYPTION', (string) envv('SMTP_ENCRYPTION', 'tls'));
define('SMTP_FROM_EMAIL', (string) envv('SMTP_FROM_EMAIL', 'noreply@dbdigitalagency.com'));
define('SMTP_FROM_NAME', (string) envv('SMTP_FROM_NAME', 'DB Digital Agency'));
define('ADMIN_EMAIL', (string) envv('ADMIN_EMAIL', 'contact@dbdigitalagency.com'));

// ============================================
// TRADUCTIONS ET CONTENU
// ============================================

$translations = [
    'en' => require __DIR__ . '/lang/en.php',
    'fr' => require __DIR__ . '/lang/fr.php',
];

// ============================================
// DONNÉES BLOG
// ============================================
$blog_posts = [
    [
        'id' => 1,
        'title_en' => 'How to Launch a Strong Digital Brand in Cameroon',
        'title_fr' => 'Comment Lancer une Marque Digitale Forte au Cameroun',
        'excerpt_en' => 'Step-by-step guidance to build an impactful digital brand for local audiences.',
        'excerpt_fr' => 'Guide étape par étape pour construire une marque digitale forte adaptée au marché camerounais.',
        'image' => 'h3_blog_img01.jpg',
        'avatar' => 'blog_avatar01.png',
        'author' => 'DB Digital Team',
        'date' => '22 Jan, 2023',
        'category_en' => 'Branding',
        'category_fr' => 'Branding',
        'url' => '#?id=1'
    ],
    [
        'id' => 2,
        'title_en' => 'Digital Transformation for African SMEs',
        'title_fr' => 'Transformation Digitale pour les PME Africaines',
        'excerpt_en' => 'How small and medium businesses in Cameroon can thrive with the right digital tools.',
        'excerpt_fr' => 'Comment les petites et moyennes entreprises camerounaises peuvent prospérer avec les bons outils digitaux.',
        'image' => 'h3_blog_img02.jpg',
        'avatar' => 'blog_avatar02.png',
        'author' => 'DB Digital Team',
        'date' => '25 Jan, 2023',
        'category_en' => 'Strategy',
        'category_fr' => 'Stratégie',
        'url' => '#?id=2'
    ],
    [
        'id' => 3,
        'title_en' => 'Growth Marketing for Startups in Cameroon',
        'title_fr' => 'Marketing de Croissance pour les Startups au Cameroun',
        'excerpt_en' => 'Performance marketing tactics to turn traffic into paying customers.',
        'excerpt_fr' => 'Tactiques de marketing de performance pour transformer le trafic en clients payants.',
        'image' => 'h3_blog_img03.jpg',
        'avatar' => 'blog_avatar03.png',
        'author' => 'DB Digital Team',
        'date' => '28 Jan, 2023',
        'category_en' => 'Marketing',
        'category_fr' => 'Marketing',
        'url' => '#?id=3'
    ],
    [
        'id' => 4,
        'title_en' => 'Website Conversion Best Practices',
        'title_fr' => 'Meilleures Pratiques de Conversion Web',
        'excerpt_en' => 'UX, copy and design techniques to increase leads and customer trust.',
        'excerpt_fr' => 'Techniques UX, rédaction et design pour augmenter les prospects et la confiance client.',
        'image' => 'h3_blog_img04.jpg',
        'avatar' => 'blog_avatar04.png',
        'author' => 'DB Digital Team',
        'date' => '01 Feb, 2023',
        'category_en' => 'Web',
        'category_fr' => 'Web',
        'url' => '#?id=4'
    ],
    [
        'id' => 5,
        'title_en' => 'Social Media Strategies for Local Business Growth',
        'title_fr' => 'Stratégies Social Media pour la Croissance des Entreprises Locales',
        'excerpt_en' => 'Practical tips to use social platforms as a sales and brand engine.',
        'excerpt_fr' => 'Conseils pratiques pour utiliser les réseaux sociaux comme levier de vente et de notoriété.',
        'image' => 'h3_blog_img05.jpg',
        'avatar' => 'blog_avatar05.png',
        'author' => 'DB Digital Team',
        'date' => '05 Feb, 2023',
        'category_en' => 'Social',
        'category_fr' => 'Social',
        'url' => '#?id=5'
    ],
    [
        'id' => 6,
        'title_en' => 'Data-Driven Decisions for Growing Companies',
        'title_fr' => 'Décisions Basées sur les Données pour les Entreprises en Croissance',
        'excerpt_en' => 'How business analytics help prioritize digital investments and optimize campaigns.',
        'excerpt_fr' => 'Comment l’analytique d’entreprise aide à prioriser les investissements digitaux et optimiser les campagnes.',
        'image' => 'h3_blog_img06.jpg',
        'avatar' => 'blog_avatar06.png',
        'author' => 'DB Digital Team',
        'date' => '10 Feb, 2023',
        'category_en' => 'Analytics',
        'category_fr' => 'Analytique',
        'url' => '#?id=6'
    ],
];

$blog_categories = [
    ['name_en' => 'Strategy', 'name_fr' => 'Stratégie', 'count' => 6],
    ['name_en' => 'Branding', 'name_fr' => 'Branding', 'count' => 4],
    ['name_en' => 'Web', 'name_fr' => 'Web', 'count' => 6],
    ['name_en' => 'SEO', 'name_fr' => 'SEO', 'count' => 5],
    ['name_en' => 'Paid Media', 'name_fr' => 'Publicité', 'count' => 5],
    ['name_en' => 'Analytics', 'name_fr' => 'Analytique', 'count' => 3],
];

$blog_tags = [
    ['en' => 'SEO', 'fr' => 'SEO'],
    ['en' => 'Conversion', 'fr' => 'Conversion'],
    ['en' => 'UI/UX', 'fr' => 'UI/UX'],
    ['en' => 'Ads', 'fr' => 'Ads'],
    ['en' => 'Content', 'fr' => 'Contenu'],
];

// ============================================
// DONNÉES PROJETS
// ============================================
$projects = [
    [
        'id' => 1,
        'title_en' => 'Digital Banking Platform',
        'title_fr' => 'Plateforme Bancaire Digitale',
        'category_en' => 'Fintech',
        'category_fr' => 'Fintech',
        'image' => 'h4_services_img01.jpg',
        'icon' => 'flaticon-healthcare',
        'description_en' => 'Complete website and onboarding experience for a local bank.',
        'description_fr' => 'Refonte du site et de l\'expérience d\'intégration pour une banque locale.',
    ],
    [
        'id' => 2,
        'title_en' => 'E-Commerce Marketplace',
        'title_fr' => 'Marketplace E-Commerce',
        'category_en' => 'Marketplace',
        'category_fr' => 'Marketplace',
        'image' => 'h4_services_img02.jpg',
        'icon' => 'flaticon-protection',
        'description_en' => 'A shopping platform connecting local artisans with online buyers.',
        'description_fr' => 'Une plateforme commerciale reliant les artisans locaux aux acheteurs en ligne.',
    ],
    [
        'id' => 3,
        'title_en' => 'Logistics Management Tool',
        'title_fr' => 'Outil de Gestion Logistique',
        'category_en' => 'Logistics',
        'category_fr' => 'Logistique',
        'image' => 'h4_services_img03.jpg',
        'icon' => 'flaticon-ship',
        'description_en' => 'Digital workflow for tracking orders and deliveries in agribusiness.',
        'description_fr' => 'Workflow digital pour le suivi des commandes et livraisons en agrobusiness.',
    ],
    [
        'id' => 4,
        'title_en' => 'Real Estate Portal',
        'title_fr' => 'Portail Immobilier',
        'category_en' => 'PropTech',
        'category_fr' => 'PropTech',
        'image' => 'h4_services_img04.jpg',
        'icon' => 'flaticon-house',
        'description_en' => 'A listing platform for property agencies and property seekers.',
        'description_fr' => 'Plateforme d\'annonces pour agences immobilières et acheteurs potentiels.',
    ],
    [
        'id' => 5,
        'title_en' => 'Tourism Booking Engine',
        'title_fr' => 'Moteur de Réservation Touristique',
        'category_en' => 'Travel',
        'category_fr' => 'Voyage',
        'image' => 'h4_services_img05.jpg',
        'icon' => 'flaticon-travel-insurance',
        'description_en' => 'Online reservation system tailored to Cameroon tourism operators.',
        'description_fr' => 'Système de réservation en ligne conçu pour les acteurs du tourisme camerounais.',
    ],
    [
        'id' => 6,
        'title_en' => 'Corporate Dashboard',
        'title_fr' => 'Tableau de Bord Corporate',
        'category_en' => 'Analytics',
        'category_fr' => 'Analytique',
        'image' => 'h4_services_img06.jpg',
        'icon' => 'flaticon-briefcase-1',
        'description_en' => 'A business intelligence dashboard for leaders to track growth metrics.',
        'description_fr' => 'Tableau de bord d\'intelligence pour suivre les indicateurs de croissance.',
    ],
    [
        'id' => 7,
        'title_en' => 'Brand Identity Refresh',
        'title_fr' => 'Refonte d\'Identité de Marque',
        'category_en' => 'Branding',
        'category_fr' => 'Branding',
        'image' => 'h4_services_img07.jpg',
        'icon' => 'flaticon-family-insurance',
        'description_en' => 'A full branding and digital presence update for a service business.',
        'description_fr' => 'Refonte complète de l\'identité et de la présence digitale d\'une entreprise de services.',
    ],
    [
        'id' => 8,
        'title_en' => 'Sales Funnel Optimization',
        'title_fr' => 'Optimisation de Tunnel de Vente',
        'category_en' => 'Marketing',
        'category_fr' => 'Marketing',
        'image' => 'h4_services_img08.jpg',
        'icon' => 'flaticon-protection',
        'description_en' => 'Improving lead conversion with clearer customer journeys and campaigns.',
        'description_fr' => 'Amélioration de la conversion grâce à des parcours clients et campagnes clarifiés.',
    ],
];
?>