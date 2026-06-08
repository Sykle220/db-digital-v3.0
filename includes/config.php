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
    // ['url' => 'blog.php', 'label_key' => 'nav_blog', 'class' => ''],
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

// Réseaux sociaux (clé = réseau affiché, utilisée par renderSocialIcons())
$social_links = [
    'facebook' => 'https://www.facebook.com/share/18a3vkULiE',
    'tiktok'   => 'https://www.tiktok.com/@db.digital.agency5',
    'youtube'  => 'https://www.youtube.com/@DBdigitalagency',
    'linkedin' => 'https://www.linkedin.com/company/db-digitalagency-com',
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
define('SMTP_FROM_EMAIL', (string) envv('SMTP_FROM_EMAIL', 'sales@dbdigitalagency.com'));
define('SMTP_FROM_NAME', (string) envv('SMTP_FROM_NAME', 'DB Digital Agency'));
define('ADMIN_EMAIL', (string) envv('ADMIN_EMAIL', 'contact@dbdigitalagency.com'));

// Upload brief (formulaire devis)
define('QUOTE_BRIEF_MAX_MB', env_int('QUOTE_BRIEF_MAX_MB', 2));
define('QUOTE_BRIEF_MAX_BYTES', QUOTE_BRIEF_MAX_MB * 1024 * 1024);

// ============================================
// TRADUCTIONS ET CONTENU
// ============================================

$translations = [
    'en' => require __DIR__ . '/lang/en.php',
    'fr' => require __DIR__ . '/lang/fr.php',
];

// ============================================
// DONNÉES SERVICES
// ============================================
$agency_services = [
    [
        'slug' => 'digital-strategy',
        'id' => 1,
        'icon' => 'flaticon-mission',
        'image' => 'h4_services_img01.jpg',
        'detail_image' => 'services_details01.jpg',
        'title_en' => 'Digital Strategy',
        'title_fr' => 'Stratégie Digitale',
        'description_en' => 'Positioning, messaging, customer journey and a clear execution plan to hit growth targets.',
        'description_fr' => 'Positionnement, message, parcours client et plan d’exécution clair pour atteindre vos objectifs.',
        'intro_en' => 'We help ambitious brands define where to play, how to win and what to build first. From market analysis to channel prioritization, we turn business goals into a concrete digital roadmap tailored to the Cameroonian and African context.',
        'intro_fr' => 'Nous aidons les marques ambitieuses à définir où se positionner, comment gagner et quoi construire en priorité. De l’analyse de marché à la priorisation des canaux, nous transformons vos objectifs business en feuille de route digitale concrète, adaptée au contexte camerounais et africain.',
        'body_en' => 'Whether you are launching a new offer or repositioning an existing brand, our strategists work alongside your leadership team to align messaging, audience segments and acquisition priorities — so every euro invested moves the needle.',
        'body_fr' => 'Que vous lanciez une nouvelle offre ou repositionniez une marque existante, nos stratèges travaillent avec votre direction pour aligner message, segments d’audience et priorités d’acquisition — afin que chaque investissement produise un impact mesurable.',
        'highlight_title_en' => 'Data-Driven Decisions',
        'highlight_title_fr' => 'Décisions guidées par la data',
        'highlight_text_en' => 'We combine market research, competitor benchmarks and analytics to prioritize initiatives with the highest ROI. No guesswork — just clear hypotheses, measurable KPIs and iterative optimization.',
        'highlight_text_fr' => 'Nous combinons étude de marché, benchmark concurrentiel et analytique pour prioriser les initiatives au meilleur ROI. Pas de suppositions — des hypothèses claires, des KPI mesurables et une optimisation continue.',
        'goal_title_en' => 'Our Goal',
        'goal_title_fr' => 'Notre objectif',
        'goal_text_en' => 'Give you a single source of truth for your digital growth: a prioritized plan your team can execute with confidence, quarter after quarter.',
        'goal_text_fr' => 'Vous offrir une vision claire de votre croissance digitale : un plan priorisé que votre équipe peut exécuter avec confiance, trimestre après trimestre.',
        'challenge_title_en' => 'Challenges We Solve',
        'challenge_title_fr' => 'Défis que nous résolvons',
        'challenge_text_en' => 'Fragmented digital presence, unclear positioning and campaigns that do not convert are common blockers we address head-on.',
        'challenge_text_fr' => 'Présence digitale fragmentée, positionnement flou et campagnes qui ne convertissent pas : nous traitons ces blocages de front.',
        'benefits_en' => ['Full digital audit & competitive scan', 'Prioritized 90-day action roadmap', 'Growth KPIs & reporting framework'],
        'benefits_fr' => ['Audit digital complet & veille concurrentielle', 'Feuille de route priorisée sur 90 jours', 'KPIs de croissance & cadre de reporting'],
        'faq' => [
            [
                'q_en' => 'How long does a digital strategy engagement take?',
                'q_fr' => 'Combien de temps dure une mission de stratégie digitale ?',
                'a_en' => 'Most strategy projects run 3 to 6 weeks depending on scope — from a focused positioning sprint to a full go-to-market plan with channel recommendations.',
                'a_fr' => 'La plupart des missions durent 3 à 6 semaines selon le périmètre — d’un sprint de positionnement ciblé à un plan go-to-market complet avec recommandations par canal.',
            ],
            [
                'q_en' => 'Do you work with startups and established companies?',
                'q_fr' => 'Travaillez-vous avec des startups et des entreprises établies ?',
                'a_en' => 'Yes. We adapt our methodology whether you are validating a new product, scaling an existing brand or entering a new market segment in Cameroon or West Africa.',
                'a_fr' => 'Oui. Nous adaptons notre méthodologie que vous validiez un nouveau produit, fassiez grandir une marque existante ou entriez sur un nouveau segment au Cameroun ou en Afrique de l’Ouest.',
            ],
            [
                'q_en' => 'What deliverables will I receive?',
                'q_fr' => 'Quels livrables vais-je recevoir ?',
                'a_en' => 'You receive a strategic brief, audience personas, channel prioritization, KPI dashboard structure and a phased execution plan your internal or external teams can follow.',
                'a_fr' => 'Vous recevez un brief stratégique, des personas, une priorisation des canaux, une structure de tableau de bord KPI et un plan d’exécution par phases utilisable par vos équipes internes ou prestataires.',
            ],
        ],
    ],
    [
        'slug' => 'web-development',
        'id' => 2,
        'icon' => 'flaticon-code',
        'image' => 'h4_services_img02.jpg',
        'detail_image' => 'services_details02.jpg',
        'title_en' => 'Web Development',
        'title_fr' => 'Développement Web',
        'description_en' => 'Fast, secure websites and web apps built for performance, SEO and conversion.',
        'description_fr' => 'Sites et applications web rapides et sécurisés, pensés performance, SEO et conversion.',
        'intro_en' => 'We build websites and web applications that load fast, rank well and convert visitors into leads. From corporate sites to custom platforms, our stack is chosen for reliability, security and long-term maintainability.',
        'intro_fr' => 'Nous concevons des sites et applications web rapides, bien référencés et orientés conversion. Du site vitrine à la plateforme sur mesure, notre stack est choisie pour la fiabilité, la sécurité et la maintenabilité dans le temps.',
        'body_en' => 'Mobile-first by default, our projects integrate analytics, SEO foundations and conversion tracking from day one — so you can measure impact as soon as you launch.',
        'body_fr' => 'Mobile-first par défaut, nos projets intègrent analytique, fondations SEO et suivi de conversion dès le jour 1 — pour mesurer l’impact dès le lancement.',
        'highlight_title_en' => 'Performance & SEO Built In',
        'highlight_title_fr' => 'Performance & SEO intégrés',
        'highlight_text_en' => 'Core Web Vitals, semantic markup, structured data and clean architecture are not add-ons — they are part of every build. Your site is ready to compete in local and international search.',
        'highlight_text_fr' => 'Core Web Vitals, balisage sémantique, données structurées et architecture propre ne sont pas des options — ils font partie de chaque livraison. Votre site est prêt à performer en recherche locale et internationale.',
        'goal_title_en' => 'Our Goal',
        'goal_title_fr' => 'Notre objectif',
        'goal_text_en' => 'Deliver a digital product your team is proud of and your customers love to use — one that scales with your business without costly rebuilds.',
        'goal_text_fr' => 'Livrer un produit digital dont votre équipe est fière et que vos clients aiment utiliser — capable de grandir avec votre activité sans refonte coûteuse.',
        'challenge_title_en' => 'Challenges We Solve',
        'challenge_title_fr' => 'Défis que nous résolvons',
        'challenge_text_en' => 'Slow load times, poor mobile experience and sites that are impossible to update are problems we eliminate with modern, maintainable code.',
        'challenge_text_fr' => 'Temps de chargement lents, mauvaise expérience mobile et sites difficiles à mettre à jour : nous les éliminons avec un code moderne et maintenable.',
        'benefits_en' => ['Optimized performance & Core Web Vitals', 'Security hardening & ongoing maintenance', 'Technical SEO & analytics integration'],
        'benefits_fr' => ['Performance optimisée & Core Web Vitals', 'Sécurisation & maintenance continue', 'SEO technique & intégration analytique'],
        'faq' => [
            [
                'q_en' => 'What technologies do you use?',
                'q_fr' => 'Quelles technologies utilisez-vous ?',
                'a_en' => 'We work with PHP, modern JavaScript, responsive CSS frameworks and proven CMS or custom architectures — always matched to your project needs and internal capabilities.',
                'a_fr' => 'Nous travaillons avec PHP, JavaScript moderne, frameworks CSS responsives et CMS ou architectures sur mesure éprouvées — toujours adaptées à votre projet et à vos capacités internes.',
            ],
            [
                'q_en' => 'Can you redesign my existing website?',
                'q_fr' => 'Pouvez-vous refondre mon site existant ?',
                'a_en' => 'Absolutely. We audit your current site, preserve what works, migrate content safely and relaunch with improved UX, speed and conversion paths.',
                'a_fr' => 'Absolument. Nous auditons votre site actuel, conservons ce qui fonctionne, migrons le contenu en sécurité et relançons avec une UX, une vitesse et des parcours de conversion améliorés.',
            ],
            [
                'q_en' => 'Do you provide hosting and support?',
                'q_fr' => 'Proposez-vous l’hébergement et le support ?',
                'a_en' => 'We can recommend and configure hosting, set up SSL, backups and monitoring, and offer maintenance plans to keep your site secure and up to date.',
                'a_fr' => 'Nous pouvons recommander et configurer l’hébergement, mettre en place SSL, sauvegardes et monitoring, et proposer des contrats de maintenance pour garder votre site sécurisé et à jour.',
            ],
        ],
    ],
    [
        'slug' => 'branding',
        'id' => 3,
        'icon' => 'flaticon-design',
        'image' => 'h4_services_img03.jpg',
        'detail_image' => 'services_details03.jpg',
        'title_en' => 'Branding & UI/UX',
        'title_fr' => 'Branding & UI/UX',
        'description_en' => 'Brand identity and product design that build trust and make people take action.',
        'description_fr' => 'Identité de marque et design produit pour renforcer la confiance et déclencher l’action.',
        'intro_en' => 'Strong brands are built on clarity, consistency and emotion. We craft visual identities and user experiences that communicate your value instantly and guide users toward action.',
        'intro_fr' => 'Les marques fortes reposent sur la clarté, la cohérence et l’émotion. Nous créons des identités visuelles et des expériences utilisateur qui communiquent votre valeur immédiatement et orientent vers l’action.',
        'body_en' => 'From logo systems and brand guidelines to wireframes and high-fidelity UI, we ensure every touchpoint — website, social, pitch deck — tells the same compelling story.',
        'body_fr' => 'Du système logo et de la charte graphique aux wireframes et UI haute fidélité, nous garantissons que chaque point de contact — site, réseaux, pitch deck — raconte la même histoire convaincante.',
        'highlight_title_en' => 'Design That Converts',
        'highlight_title_fr' => 'Un design qui convertit',
        'highlight_text_en' => 'We combine brand strategy with UX best practices: clear hierarchy, accessible typography, tested layouts and CTAs placed where users naturally look.',
        'highlight_text_fr' => 'Nous combinons stratégie de marque et bonnes pratiques UX : hiérarchie claire, typographie accessible, mises en page testées et CTA placés là où l’utilisateur regarde naturellement.',
        'goal_title_en' => 'Our Goal',
        'goal_title_fr' => 'Notre objectif',
        'goal_text_en' => 'Make your brand instantly recognizable and trustworthy — online and offline — so prospects choose you before they even read your offer.',
        'goal_text_fr' => 'Rendre votre marque immédiatement reconnaissable et rassurante — en ligne comme hors ligne — pour que vos prospects vous choisissent avant même de lire votre offre.',
        'challenge_title_en' => 'Challenges We Solve',
        'challenge_title_fr' => 'Défis que nous résolvons',
        'challenge_text_en' => 'Inconsistent visuals, outdated identity and interfaces that confuse users cost you credibility and sales every day.',
        'challenge_text_fr' => 'Des visuels incohérents, une identité dépassée et des interfaces qui perdent l’utilisateur vous coûtent crédibilité et ventes chaque jour.',
        'benefits_en' => ['Cohesive visual identity & brand guidelines', 'UX research & tested interface design', 'Design assets ready for web & print'],
        'benefits_fr' => ['Identité visuelle cohérente & charte graphique', 'Recherche UX & interfaces testées', 'Assets prêts pour le web et l’impression'],
        'faq' => [
            [
                'q_en' => 'What is included in a branding package?',
                'q_fr' => 'Que comprend un pack branding ?',
                'a_en' => 'Typically: brand strategy workshop, logo variations, color palette, typography, iconography, brand guidelines and key application mockups (website, social, stationery).',
                'a_fr' => 'En général : atelier stratégie de marque, déclinaisons logo, palette couleurs, typographie, iconographie, charte graphique et maquettes clés (site, réseaux, papeterie).',
            ],
            [
                'q_en' => 'Do you also design websites?',
                'q_fr' => 'Concevez-vous aussi les sites web ?',
                'a_en' => 'Yes. UI/UX design and web development work hand in hand in our studio — ensuring the final product matches the brand vision pixel for pixel.',
                'a_fr' => 'Oui. UI/UX et développement web vont de pair dans notre studio — le produit final correspond à la vision de marque, pixel par pixel.',
            ],
            [
                'q_en' => 'How many revision rounds are included?',
                'q_fr' => 'Combien de cycles de révision sont inclus ?',
                'a_en' => 'Each project includes structured feedback rounds defined upfront. We collaborate closely to refine until the identity aligns with your vision and business goals.',
                'a_fr' => 'Chaque projet inclut des cycles de retours structurés définis en amont. Nous affinons ensemble jusqu’à ce que l’identité corresponde à votre vision et à vos objectifs business.',
            ],
        ],
    ],
    [
        'slug' => 'marketing',
        'id' => 4,
        'icon' => 'flaticon-profit',
        'image' => 'h4_services_img04.jpg',
        'detail_image' => 'services_details04.jpg',
        'title_en' => 'Growth Marketing',
        'title_fr' => 'Marketing d’Acquisition',
        'description_en' => 'SEO, paid media and content systems that consistently generate qualified leads.',
        'description_fr' => 'SEO, publicité et contenus qui génèrent des prospects qualifiés de façon régulière.',
        'intro_en' => 'Traffic without conversion is wasted budget. We build acquisition systems — SEO, paid ads, email and content — that attract the right audience and turn interest into qualified leads.',
        'intro_fr' => 'Du trafic sans conversion, c’est du budget gaspillé. Nous construisons des systèmes d’acquisition — SEO, publicité, email et contenu — qui attirent la bonne audience et transforment l’intérêt en prospects qualifiés.',
        'body_en' => 'Grounded in analytics and continuous testing, our campaigns are optimized for ROI — with transparent reporting so you always know what is working.',
        'body_fr' => 'Fondées sur l’analytique et les tests continus, nos campagnes sont optimisées pour le ROI — avec un reporting transparent pour savoir en permanence ce qui fonctionne.',
        'highlight_title_en' => 'Measurable Growth',
        'highlight_title_fr' => 'Croissance mesurable',
        'highlight_text_en' => 'We set up tracking, attribution and dashboards from the start. Every campaign is tied to business outcomes: leads, sales, cost per acquisition and lifetime value.',
        'highlight_text_fr' => 'Nous mettons en place tracking, attribution et tableaux de bord dès le départ. Chaque campagne est liée à des résultats business : leads, ventes, coût d’acquisition et valeur vie client.',
        'goal_title_en' => 'Our Goal',
        'goal_title_fr' => 'Notre objectif',
        'goal_text_en' => 'Build a predictable pipeline of qualified prospects so your sales team spends time closing — not chasing cold leads.',
        'goal_text_fr' => 'Construire un flux prévisible de prospects qualifiés pour que vos commerciaux passent leur temps à conclure — pas à courir après des contacts froids.',
        'challenge_title_en' => 'Challenges We Solve',
        'challenge_title_fr' => 'Défis que nous résolvons',
        'challenge_text_en' => 'Ad spend with no tracking, poor local SEO visibility and content that does not rank are growth killers we fix with structured, test-driven campaigns.',
        'challenge_text_fr' => 'Budget pub sans suivi, faible visibilité SEO locale et contenus qui ne se positionnent pas : nous corrigeons ces freins avec des campagnes structurées et orientées tests.',
        'benefits_en' => ['Tracked campaigns with clear ROI reporting', 'Local SEO for Cameroon & West Africa', 'Content that ranks and converts'],
        'benefits_fr' => ['Campagnes trackées avec reporting ROI clair', 'SEO local Cameroun & Afrique de l’Ouest', 'Contenus qui se positionnent et convertissent'],
        'faq' => [
            [
                'q_en' => 'Which advertising platforms do you manage?',
                'q_fr' => 'Quelles plateformes publicitaires gérez-vous ?',
                'a_en' => 'Google Ads, Meta (Facebook & Instagram), LinkedIn and TikTok — depending on where your audience is most active and cost-effective for your sector.',
                'a_fr' => 'Google Ads, Meta (Facebook & Instagram), LinkedIn et TikTok — selon l’endroit où votre audience est la plus active et rentable pour votre secteur.',
            ],
            [
                'q_en' => 'How soon can I expect results from SEO?',
                'q_fr' => 'En combien de temps le SEO produit-il des résultats ?',
                'a_en' => 'SEO is a medium-term investment. Most clients see meaningful ranking improvements within 3 to 6 months, with compounding returns over time.',
                'a_fr' => 'Le SEO est un investissement moyen terme. La plupart des clients constatent des gains de positionnement significatifs en 3 à 6 mois, avec des retours qui s’accumulent dans le temps.',
            ],
            [
                'q_en' => 'Can you work with our in-house marketing team?',
                'q_fr' => 'Pouvez-vous travailler avec notre équipe marketing interne ?',
                'a_en' => 'Yes. We often complement internal teams — handling strategy, setup and optimization while your team manages day-to-day community or brand voice.',
                'a_fr' => 'Oui. Nous complétons souvent les équipes internes — stratégie, paramétrage et optimisation de notre côté, community ou tonalité de marque de votre côté.',
            ],
        ],
    ],
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