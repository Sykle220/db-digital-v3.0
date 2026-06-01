<?php
// includes/config.php

define('SITE_NAME', 'DB Digital Agency');
define('BASE_URL', '');
define('ASSETS_URL', BASE_URL . 'assets/');

// Navigation principale
$nav_items = [
    ['url' => 'index.php', 'label_key' => 'nav_home', 'class' => ''],
    ['url' => 'about.php', 'label_key' => 'nav_about', 'class' => ''],
    ['url' => 'services.php', 'label_key' => 'nav_services', 'class' => ''],
    ['url' => 'projects.php', 'label_key' => 'nav_projects', 'class' => ''],
    ['url' => 'blog.php', 'label_key' => 'nav_blog', 'class' => ''],
    // ['url' => 'contact.php', 'label_key' => 'nav_contact', 'class' => ''],
];

// Coordonnées
define('CONTACT_ADDRESS', 'Entrée Carriere, Nkoabang, Yaoundé, Cameroon');
define('CONTACT_PHONE_1', '+237 691 323 249');
define('CONTACT_PHONE_2', '+237 658 910 343');
define('CONTACT_PHONE_3', '+237 640 819 846');
define('CONTACT_EMAIL', 'contact@dbdigitalagency.com');

// WhatsApp (numéro sans espaces pour l'URL)
define('WHATSAPP_NUMBER', '237691323249');

// Réseaux sociaux
$social_links = [
    'facebook'  => '#',
    'twitter'   => '#',
    'instagram' => '#',
    'linkedin'  => '#',
];

// ============================================
// SYSTÈME MULTILINGUE
// ============================================
session_start();

// Langues disponibles
$available_langs = ['en', 'fr'];
$default_lang = 'fr';

// Détection de la langue
if (isset($_GET['lang']) && in_array($_GET['lang'], $available_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
    $current_lang = $_GET['lang'];
} elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $available_langs)) {
    $current_lang = $_SESSION['lang'];
} else {
    $current_lang = $default_lang;
}

// ============================================
// CONFIGURATION BASE DE DONNÉES
// ============================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'dbdigitalagency');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// CONFIGURATION EMAIL / SMTP
// ============================================
define('SMTP_HOST', 'smtp.gmail.com');      // ou smtp.mailgun.com, smtp.sendgrid.net
define('SMTP_PORT', 587);                   // 587 pour TLS, 465 pour SSL
define('SMTP_USERNAME', 'votre-email@gmail.com');  // MODIFIEZ ICI
define('SMTP_PASSWORD', 'votre-mot-de-passe-app'); // MODIFIEZ ICI (mot de passe d'application)
define('SMTP_ENCRYPTION', 'tls');            // tls ou ssl
define('SMTP_FROM_EMAIL', 'noreply@dbdigitalagency.com');
define('SMTP_FROM_NAME', 'DB Digital Agency');
define('ADMIN_EMAIL', 'contact@dbdigitalagency.com');

// ============================================
// TRADUCTIONS ET CONTENU
// ============================================

$translations = [
    'en' => [
        'nav_home' => 'Home',
        'nav_about' => 'About Us',
        'nav_services' => 'Services',
        'nav_projects' => 'Projects',
        'nav_blog' => 'Blog',
        'nav_contact' => 'Contact',
        'btn_quote' => 'Get A Quote',
        'btn_read_more' => 'Read More',
        'btn_see_all' => 'See All',
        'btn_contact' => 'Contact Us',
        'hero_title' => 'Build high-performance digital products',
        'hero_desc' => 'We build high-performance digital platforms and customer acquisition systems that help ambitious businesses grow faster and more efficiently.',
        'features_growing' => 'Digital Strategy',
        'features_finance' => 'Growth Marketing',
        'features_tax' => 'Brand & Design',
        'about_subtitle' => 'Who we are',
        'about_page_subtitle' => 'Who we are',
        'about_title' => 'Innovation and growth for digital businesses',
        'about_page_title' => 'Innovation and growth for digital businesses',
        'about_page_desc' => 'We are a Yaoundé-based digital agency helping businesses create strong online brands, convert more customers and scale through high-performance digital experiences.',
        'about_ceo' => 'CEO, DB Digital Agency',
        'services_subtitle' => 'What We Do For You',
        'services_title' => 'A Wide Range Of Services For Your Business!',
        'services_btn' => 'See All Services',
        'counter_projects' => 'Projects Delivered',
        'counter_clients' => 'Satisfied Clients',
        'counter_awards' => 'Awards Earned',
        'counter_countries' => 'Countries Served',
        'call_for_more_info' => 'Call For More Info',
        'call_desc' => 'Let\'s Request a Schedule For Free Consultation',
        'projects_subtitle' => 'Case Studies',
        'projects_title' => 'We have helped brands grow with strong digital solutions',
        'projects_btn' => 'See All Projects',
        'team_subtitle' => 'Expert People',
        'team_title' => 'Our Dedicated Team Members',
        'testimonial_title' => 'What Our Clients Say',
        'blog_subtitle' => 'Insights & Articles',
        'blog_title' => 'Read Our Latest Updates',
        'footer_newsletter' => 'Subscribe to Our Newsletter',
        'footer_newsletter_desc' => 'Sign up to our weekly newsletter to get the latest updates.',
        'footer_email_placeholder' => 'enter your e-mail',
        'footer_subscribe' => 'Subscribe',
        'footer_no_spam' => 'We don\'t send you any spam',
        'footer_copyright' => 'Copyright © dbdigitalagency | All Right Reserved',
        'whatsapp_text' => 'Chat on WhatsApp',
        'quote_title' => 'Request a Quote',
        'quote_subtitle' => 'Get your custom digital quote today',
        'quote_desc' => 'Tell us about your project and we will provide a tailored proposal that fits your goals.',
        'quote_quick_response' => 'Fast response time',
        'quote_secure_approach' => 'Secure and professional process',
        'quote_talk_to_us' => 'Talk to Us',
        'quote_step_service' => 'Service',
        'quote_step_project' => 'Project',
        'quote_step_contact' => 'Contact',
        'quote_step_review' => 'Review',
        'quote_service_label' => 'Service',
        'quote_subject_label' => 'Project Subject',
        'quote_type_label' => 'Project Type',
        'quote_budget_label' => 'Budget',
        'quote_start_label' => 'Start Date',
        'quote_message_label' => 'Project Details',
        'quote_brief_label' => 'Upload Brief',
        'quote_file_hint' => 'Attach any relevant project documents here.',
        'quote_fullname_label' => 'Full Name',
        'quote_company_label' => 'Company',
        'quote_email_label' => 'Email Address',
        'quote_whatsapp_label' => 'WhatsApp Number',
        'quote_review_title' => 'Review',
        'quote_ask_question' => 'Send Request',
        'quote_innovation_title' => 'Innovation Starts Here',
        'quote_option_email' => 'Send by Email',
        'quote_option_whatsapp' => 'Send via WhatsApp',
        'quote_send_method' => 'Send Method',
        'quote_success_email' => 'Your quote request has been sent successfully! We will contact you soon.',
        'quote_success_whatsapp' => 'Redirecting to WhatsApp...',
        'quote_error_db' => 'Unable to save your request. Please try again.',
        'quote_error_email' => 'Request saved but email failed. We will contact you via WhatsApp.',
        'quote_whatsapp_intro' => 'Hello DB Digital Agency, I would like a quote for the following project:',
        'quote_whatsapp_service' => 'Service',
        'quote_whatsapp_subject' => 'Subject',
        'quote_whatsapp_type' => 'Type',
        'quote_whatsapp_budget' => 'Budget',
        'quote_whatsapp_start' => 'Start',
        'quote_whatsapp_name' => 'Name',
        'quote_whatsapp_company' => 'Company',
        'quote_whatsapp_email' => 'Email',
        'quote_whatsapp_message' => 'Message',
        'quote_db_saved' => 'Request saved in database',
        'breadcrumb_home' => 'Home',
        'breadcrumb_about' => 'About',
        'breadcrumb_services' => 'Services',
        'breadcrumb_projects' => 'Projects',
        'breadcrumb_blog' => 'Blog',
        'breadcrumb_contact' => 'Contact',
        'about_subtitle' => 'Who we are',
        'about_title' => 'Innovation and growth for digital businesses',
        'about_desc' => 'We are a Yaoundé-based digital agency helping businesses create strong online brands, convert more customers and scale through high-performance digital experiences.',
        'about_expertise' => 'Digital Consulting & Growth Agency',
        'about_expertise_title' => 'Digital product, growth and branding expertise',
        'about_expertise_subtitle' => 'Expertise areas',
        'about_expertise_desc' => 'We help brands design high-converting digital journeys and launch acquisition campaigns that deliver measurable growth.',
        'about_skill_strategy' => 'Digital Strategy',
        'about_skill_brand' => 'Brand Experience',
        'about_skill_growth' => 'Customer Acquisition',
        'about_service_btn' => 'Start a Project',
        'about_company_type_1' => 'Digital Creative Agency',
        'about_company_type_2' => 'Professional Problem Solutions',
        'about_company_type_3' => 'Web Design & Development',
        'services_page_title' => 'Our Services',
        'services_page_subtitle' => 'Comprehensive Solutions for Your Business',
        'search_placeholder' => 'Search Here...',
    ],
    'fr' => [
        'nav_home' => 'Accueil',
        'nav_about' => 'À Propos',
        'nav_services' => 'Services',
        'nav_projects' => 'Projets',
        'nav_blog' => 'Blog',
        'nav_contact' => 'Contact',
        'btn_quote' => 'Demander un Devis',
        'btn_read_more' => 'En Savoir Plus',
        'btn_see_all' => 'Voir Tout',
        'btn_contact' => 'Nous Contacter',
        'hero_title' => 'CONSTRUIRE. ACQUÉRIR. CROÎTRE.',
        'hero_desc' => 'Nous concevons des plateformes web et mobiles performantes et des systèmes d\'acquisition client pour accélérer la croissance des entreprises ambitieuses.',
        'features_growing' => 'Stratégie Digitale',
        'features_finance' => 'Marketing d\'Acquisition',
        'features_tax' => 'Branding & Design',
        'about_subtitle' => 'Qui nous sommes',
        'about_page_subtitle' => 'Qui nous sommes',
        'about_title' => 'Innovation et croissance pour les entreprises digitales',
        'about_page_title' => 'Innovation et croissance pour les entreprises digitales',
        'about_page_desc' => 'Nous sommes une agence digitale basée à Yaoundé, aidant les entreprises à créer des marques fortes, à convertir davantage de clients et à croître grâce à des expériences digitales performantes.',
        'about_ceo' => 'PDG, DB Digital Agency',
        'services_subtitle' => 'Ce Que Nous Faisons Pour Vous',
        'services_title' => 'Une Large Gamme de Services Pour Votre Entreprise !',
        'services_btn' => 'Voir Tous les Services',
        'counter_projects' => 'Projets Réalisés',
        'counter_clients' => 'Clients Satisfaits',
        'counter_awards' => 'Récompenses Obtenues',
        'counter_countries' => 'Pays Desservis',
        'call_for_more_info' => 'Appeler pour plus d\'infos',
        'call_desc' =>  'Demandez un rendez-vous pour une consultation gratuite',
        'projects_subtitle' => 'Études de Cas',
        'projects_title' => 'Nous avons aidé des marques à croître grâce à des solutions digitales solides',
        'projects_btn' => 'Voir Tous les Projets',
        'team_subtitle' => 'Experts',
        'team_title' => 'Les Membres de Notre Équipe Dévouée',
        'testimonial_title' => 'Ce Que Disent Nos Clients',
        'blog_subtitle' => 'Actualités & Blogs',
        'blog_title' => 'Lisez Nos Dernières Mises à Jour',
        'footer_newsletter' => 'Abonnez-vous à Notre Newsletter',
        'footer_newsletter_desc' => 'Inscrivez-vous à notre newsletter hebdomadaire pour recevoir les dernières actualités.',
        'footer_email_placeholder' => 'entrez votre e-mail',
        'footer_subscribe' => 'S\'abonner',
        'footer_no_spam' => 'Nous ne vous envoyons pas de spam',
        'footer_copyright' => 'Copyright © dbdigitalagency | Tous Droits Réservés',
        'whatsapp_text' => 'Discuter sur WhatsApp',
        'quote_title' => 'Demandez un Devis',
        'quote_subtitle' => 'Obtenez votre devis digital personnalisé aujourd\'hui',
        'quote_desc' => 'Parlez-nous de votre projet et nous vous proposerons une proposition adaptée à vos objectifs.',
        'quote_quick_response' => 'Réponse rapide',
        'quote_secure_approach' => 'Processus sécurisé et professionnel',
        'quote_talk_to_us' => 'Parlez-nous',
        'quote_step_service' => 'Service',
        'quote_step_project' => 'Projet',
        'quote_step_contact' => 'Contact',
        'quote_step_review' => 'Revoir',
        'quote_service_label' => 'Service',
        'quote_subject_label' => 'Sujet du Projet',
        'quote_type_label' => 'Type de Projet',
        'quote_budget_label' => 'Budget',
        'quote_start_label' => 'Date de début',
        'quote_message_label' => 'Détails du Projet',
        'quote_brief_label' => 'Télécharger le Brief',
        'quote_file_hint' => 'Joignez ici tous les documents de projet pertinents.',
        'quote_fullname_label' => 'Nom Complet',
        'quote_company_label' => 'Entreprise',
        'quote_email_label' => 'Adresse Email',
        'quote_whatsapp_label' => 'Numéro WhatsApp',
        'quote_review_title' => 'Revoir',
        'quote_ask_question' => 'Envoyer la demande',
        'quote_innovation_title' => 'L\'innovation commence ici',
        'quote_option_email' => 'Envoyer par Email',
        'quote_option_whatsapp' => 'Envoyer via WhatsApp',
        'quote_send_method' => 'Méthode d\'envoi',
        'quote_success_email' => 'Votre demande de devis a été envoyée avec succès ! Nous vous contacterons bientôt.',
        'quote_success_whatsapp' => 'Redirection vers WhatsApp...',
        'quote_error_db' => 'Impossible de sauvegarder votre demande. Veuillez réessayer.',
        'quote_error_email' => 'Demande sauvegardée mais l\'email a échoué. Nous vous contacterons via WhatsApp.',
        'quote_whatsapp_intro' => 'Bonjour DB Digital Agency, je souhaiterais un devis pour le projet suivant :',
        'quote_whatsapp_service' => 'Service',
        'quote_whatsapp_subject' => 'Sujet',
        'quote_whatsapp_type' => 'Type',
        'quote_whatsapp_budget' => 'Budget',
        'quote_whatsapp_start' => 'Début',
        'quote_whatsapp_name' => 'Nom',
        'quote_whatsapp_company' => 'Entreprise',
        'quote_whatsapp_email' => 'Email',
        'quote_whatsapp_message' => 'Message',
        'quote_db_saved' => 'Demande sauvegardée en base de données',
        'breadcrumb_home' => 'Accueil',
        'breadcrumb_about' => 'À Propos',
        'breadcrumb_services' => 'Services',
        'breadcrumb_projects' => 'Projets',
        'breadcrumb_blog' => 'Blog',
        'breadcrumb_contact' => 'Contact',
        'about_subtitle' => 'Qui sommes-nous',
        'about_title' => 'Construire l\'avenir numérique des entreprises',
        'about_desc' => 'Nous sommes une agence numérique de premier plan basée à Yaoundé, au Cameroun, aidant les entreprises à transformer leur présence numérique et à réaliser une croissance durable grâce à des stratégies innovantes.',
        'about_expertise' => 'Agence de Conseil Numérique et Croissance',
        'about_expertise_title' => 'Expertise en produit digital, croissance et branding',
        'about_expertise_subtitle' => 'Domaines d\'expertise',
        'about_expertise_desc' => 'Nous aidons les marques à concevoir des parcours digitaux performants et à lancer des campagnes d\'acquisition qui génèrent une croissance mesurable.',
        'about_skill_strategy' => 'Stratégie Numérique',
        'about_skill_brand' => 'Expérience de Marque',
        'about_skill_growth' => 'Croissance Commerciale',
        'about_service_btn' => 'Utiliser nos Services',
        'about_company_type_1' => 'Agence Créative Numérique',
        'about_company_type_2' => 'Solutions Professionnelles',
        'about_company_type_3' => 'Design & Développement Web',
        'services_page_title' => 'Nos Services',
        'services_page_subtitle' => 'Solutions Complètes pour Votre Entreprise',
        'search_placeholder' => 'Rechercher ici...',
    ],
];

// Fonction de traduction
function __($key) {
    global $translations, $current_lang;
    return $translations[$current_lang][$key] ?? $key;
}

// Message WhatsApp selon la langue
$whatsapp_messages = [
    'en' => 'Hello DB Digital Agency, I would like a tailored quote for my digital project.',
    'fr' => 'Bonjour DB Digital Agency, je souhaite un devis personnalisé pour mon projet digital.',
];
define('WHATSAPP_MESSAGE', $whatsapp_messages[$current_lang]);

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
    ['name_en' => 'Business', 'name_fr' => 'Entreprise', 'count' => 2],
    ['name_en' => 'Consulting', 'name_fr' => 'Consultation', 'count' => 8],
    ['name_en' => 'Corporate', 'name_fr' => 'Corporate', 'count' => 5],
    ['name_en' => 'Design', 'name_fr' => 'Design', 'count' => 2],
    ['name_en' => 'Fashion', 'name_fr' => 'Mode', 'count' => 11],
    ['name_en' => 'Marketing', 'name_fr' => 'Marketing', 'count' => 12],
];

$blog_tags = [
    ['en' => 'Finance', 'fr' => 'Finance'],
    ['en' => 'Consultancy', 'fr' => 'Consultation'],
    ['en' => 'Data', 'fr' => 'Données'],
    ['en' => 'Agency', 'fr' => 'Agence'],
    ['en' => 'Travel', 'fr' => 'Voyage'],
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