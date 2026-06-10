-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2026 at 08:21 AM
-- Server version: 8.0.46-0ubuntu0.24.04.2
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbdigitalagency`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_log`
--

CREATE TABLE `admin_activity_log` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `entity_type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `entity_id` int DEFAULT NULL,
  `details` text COLLATE utf8mb4_general_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity_log`
--

INSERT INTO `admin_activity_log` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES
(2, 1, 'update', 'branding', NULL, NULL, '::1', '2026-06-09 14:14:12'),
(3, 1, 'update', 'translations', NULL, 'Groupe: app', '::1', '2026-06-09 14:14:28'),
(4, 1, 'update', 'translations', NULL, 'Groupe: footer', '::1', '2026-06-09 14:16:02'),
(5, 1, 'update', 'team_member', 2, NULL, '::1', '2026-06-10 08:11:46'),
(6, 1, 'update', 'team_member', 2, NULL, '::1', '2026-06-10 08:11:56'),
(7, 1, 'create', 'page', 5, NULL, '::1', '2026-06-10 08:13:00'),
(8, 1, 'update', 'page', 5, NULL, '::1', '2026-06-10 08:13:13'),
(9, 1, 'delete', 'page', 5, NULL, '::1', '2026-06-10 08:13:19'),
(10, 1, 'update', 'service', 1, NULL, '::1', '2026-06-10 08:13:56'),
(11, 1, 'update', 'service', 1, NULL, '::1', '2026-06-10 08:14:11'),
(12, 1, 'update', 'blog_post', 1, NULL, '::1', '2026-06-10 08:14:24'),
(13, 1, 'update', 'blog_post', 1, NULL, '::1', '2026-06-10 08:14:38');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `entity_type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `entity_id` int UNSIGNED DEFAULT NULL,
  `details` text COLLATE utf8mb4_general_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(1, 1, 'superadmin', '2026-06-08 15:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secret` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `secret2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text COLLATE utf8mb4_general_ci,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'admin@dbdigitalagency.com', '$2y$12$L3T0Ueg3mOdsoDQ8xznQdul8IMPuO9kIgBVAT3ZFQz2vZ5O4cdqP6', NULL, NULL, 0, '2026-06-10 07:30:51', '2026-06-08 15:19:41', '2026-06-10 07:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'email_password', 'admin@dbdigitalagency.com', 1, '2026-06-08 16:56:16', 1),
(2, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'email_password', 'admin@dbdigitalagency.com', 1, '2026-06-08 19:51:23', 1),
(3, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'email_password', 'admin@dbdigitalagency.com', 1, '2026-06-09 07:45:35', 1),
(4, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'email_password', 'admin@dbdigitalagency.com', 1, '2026-06-10 07:30:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hashedValidator` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `slug`, `sort_order`) VALUES
(1, 'strategy', 1),
(2, 'branding', 2),
(3, 'web', 3),
(4, 'seo', 4),
(5, 'paid-media', 5),
(6, 'analytics', 6),
(7, 'marketing', 7),
(8, 'social', 8);

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_translations`
--

CREATE TABLE `blog_category_translations` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_category_translations`
--

INSERT INTO `blog_category_translations` (`id`, `category_id`, `locale`, `name`) VALUES
(1, 1, 'fr', 'Stratégie'),
(2, 1, 'en', 'Strategy'),
(3, 2, 'fr', 'Branding'),
(4, 2, 'en', 'Branding'),
(5, 3, 'fr', 'Web'),
(6, 3, 'en', 'Web'),
(7, 4, 'fr', 'SEO'),
(8, 4, 'en', 'SEO'),
(9, 5, 'fr', 'Publicité'),
(10, 5, 'en', 'Paid Media'),
(11, 6, 'fr', 'Analytique'),
(12, 6, 'en', 'Analytics'),
(13, 7, 'fr', 'Marketing'),
(14, 7, 'en', 'Marketing'),
(15, 8, 'fr', 'Social'),
(16, 8, 'en', 'Social');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int UNSIGNED DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `slug`, `category_id`, `image`, `author`, `published_at`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'how-to-launch-a-strong-digital-brand-in-cameroon', 2, 'h3_blog_img01.jpg', 'DB Digital Team', '2026-01-22 20:23:00', 1, 1, NULL, '2026-06-10 08:14:38'),
(2, 'digital-transformation-for-african-smes', 1, 'h3_blog_img02.jpg', 'DB Digital Team', '2026-01-25 20:23:00', 1, 2, NULL, NULL),
(3, 'growth-marketing-for-startups-in-cameroon', 7, 'h3_blog_img03.jpg', 'DB Digital Team', '2026-01-28 20:23:00', 1, 3, NULL, NULL),
(4, 'website-conversion-best-practices', 3, 'h3_blog_img04.jpg', 'DB Digital Team', '2026-02-01 20:23:00', 1, 4, NULL, NULL),
(5, 'social-media-strategies-for-local-business-growth', 8, 'h3_blog_img05.jpg', 'DB Digital Team', '2026-02-05 20:23:00', 1, 5, NULL, NULL),
(6, 'data-driven-decisions-for-growing-companies', 6, 'h3_blog_img06.jpg', 'DB Digital Team', '2026-02-10 20:23:00', 1, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_translations`
--

CREATE TABLE `blog_post_translations` (
  `id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `content` longtext COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_post_translations`
--

INSERT INTO `blog_post_translations` (`id`, `post_id`, `locale`, `title`, `excerpt`, `content`) VALUES
(1, 1, 'fr', 'Comment Lancer une Marque Digitale Forte au Cameroun', 'Guide étape par étape pour construire une marque digitale forte adaptée au marché camerounais.', 'Guide étape par étape pour construire une marque digitale forte adaptée au marché camerounais.'),
(2, 1, 'en', 'How to Launch a Strong Digital Brand in Cameroon', 'Step-by-step guidance to build an impactful digital brand for local audiences.', 'Step-by-step guidance to build an impactful digital brand for local audiences.'),
(3, 2, 'fr', 'Transformation Digitale pour les PME Africaines', 'Comment les petites et moyennes entreprises camerounaises peuvent prospérer avec les bons outils digitaux.', 'Comment les petites et moyennes entreprises camerounaises peuvent prospérer avec les bons outils digitaux.'),
(4, 2, 'en', 'Digital Transformation for African SMEs', 'How small and medium businesses in Cameroon can thrive with the right digital tools.', 'How small and medium businesses in Cameroon can thrive with the right digital tools.'),
(5, 3, 'fr', 'Marketing de Croissance pour les Startups au Cameroun', 'Tactiques de marketing de performance pour transformer le trafic en clients payants.', 'Tactiques de marketing de performance pour transformer le trafic en clients payants.'),
(6, 3, 'en', 'Growth Marketing for Startups in Cameroon', 'Performance marketing tactics to turn traffic into paying customers.', 'Performance marketing tactics to turn traffic into paying customers.'),
(7, 4, 'fr', 'Meilleures Pratiques de Conversion Web', 'Techniques UX, rédaction et design pour augmenter les prospects et la confiance client.', 'Techniques UX, rédaction et design pour augmenter les prospects et la confiance client.'),
(8, 4, 'en', 'Website Conversion Best Practices', 'UX, copy and design techniques to increase leads and customer trust.', 'UX, copy and design techniques to increase leads and customer trust.'),
(9, 5, 'fr', 'Stratégies Social Media pour la Croissance des Entreprises Locales', 'Conseils pratiques pour utiliser les réseaux sociaux comme levier de vente et de notoriété.', 'Conseils pratiques pour utiliser les réseaux sociaux comme levier de vente et de notoriété.'),
(10, 5, 'en', 'Social Media Strategies for Local Business Growth', 'Practical tips to use social platforms as a sales and brand engine.', 'Practical tips to use social platforms as a sales and brand engine.'),
(11, 6, 'fr', 'Décisions Basées sur les Données pour les Entreprises en Croissance', 'Comment l’analytique d’entreprise aide à prioriser les investissements digitaux et optimiser les campagnes.', 'Comment l’analytique d’entreprise aide à prioriser les investissements digitaux et optimiser les campagnes.'),
(12, 6, 'en', 'Data-Driven Decisions for Growing Companies', 'How business analytics help prioritize digital investments and optimize campaigns.', 'How business analytics help prioritize digital investments and optimize campaigns.');

-- --------------------------------------------------------

--
-- Table structure for table `brand_logos`
--

CREATE TABLE `brand_logos` (
  `id` int UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_logos`
--

INSERT INTO `brand_logos` (`id`, `filename`, `name`, `sort_order`, `is_active`) VALUES
(1, 'brand_img01.png', 'brand_img01', 1, 1),
(2, 'brand_img02.png', 'brand_img02', 2, 1),
(3, 'brand_img05.png', 'brand_img05', 3, 1),
(4, 'brand_img03.png', 'brand_img03', 4, 1),
(5, 'brand_img04.png', 'brand_img04', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `status` enum('new','read','replied','archived') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'new',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_translations`
--

CREATE TABLE `faq_translations` (
  `id` int UNSIGNED NOT NULL,
  `faq_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_translations`
--

INSERT INTO `faq_translations` (`id`, `faq_id`, `locale`, `question`, `answer`) VALUES
(127, 64, 'fr', 'Quelles technologies utilisez-vous ?', 'Nous travaillons avec PHP, JavaScript moderne, frameworks CSS responsives et CMS ou architectures sur mesure éprouvées — toujours adaptées à votre projet et à vos capacités internes.'),
(128, 64, 'en', 'What technologies do you use?', 'We work with PHP, modern JavaScript, responsive CSS frameworks and proven CMS or custom architectures — always matched to your project needs and internal capabilities.'),
(129, 65, 'fr', 'Pouvez-vous refondre mon site existant ?', 'Absolument. Nous auditons votre site actuel, conservons ce qui fonctionne, migrons le contenu en sécurité et relançons avec une UX, une vitesse et des parcours de conversion améliorés.'),
(130, 65, 'en', 'Can you redesign my existing website?', 'Absolutely. We audit your current site, preserve what works, migrate content safely and relaunch with improved UX, speed and conversion paths.'),
(131, 66, 'fr', 'Proposez-vous l’hébergement et le support ?', 'Nous pouvons recommander et configurer l’hébergement, mettre en place SSL, sauvegardes et monitoring, et proposer des contrats de maintenance pour garder votre site sécurisé et à jour.'),
(132, 66, 'en', 'Do you provide hosting and support?', 'We can recommend and configure hosting, set up SSL, backups and monitoring, and offer maintenance plans to keep your site secure and up to date.'),
(133, 67, 'fr', 'Que comprend un pack branding ?', 'En général : atelier stratégie de marque, déclinaisons logo, palette couleurs, typographie, iconographie, charte graphique et maquettes clés (site, réseaux, papeterie).'),
(134, 67, 'en', 'What is included in a branding package?', 'Typically: brand strategy workshop, logo variations, color palette, typography, iconography, brand guidelines and key application mockups (website, social, stationery).'),
(135, 68, 'fr', 'Concevez-vous aussi les sites web ?', 'Oui. UI/UX et développement web vont de pair dans notre studio — le produit final correspond à la vision de marque, pixel par pixel.'),
(136, 68, 'en', 'Do you also design websites?', 'Yes. UI/UX design and web development work hand in hand in our studio — ensuring the final product matches the brand vision pixel for pixel.'),
(137, 69, 'fr', 'Combien de cycles de révision sont inclus ?', 'Chaque projet inclut des cycles de retours structurés définis en amont. Nous affinons ensemble jusqu’à ce que l’identité corresponde à votre vision et à vos objectifs business.'),
(138, 69, 'en', 'How many revision rounds are included?', 'Each project includes structured feedback rounds defined upfront. We collaborate closely to refine until the identity aligns with your vision and business goals.'),
(139, 70, 'fr', 'Quelles plateformes publicitaires gérez-vous ?', 'Google Ads, Meta (Facebook & Instagram), LinkedIn et TikTok — selon l’endroit où votre audience est la plus active et rentable pour votre secteur.'),
(140, 70, 'en', 'Which advertising platforms do you manage?', 'Google Ads, Meta (Facebook & Instagram), LinkedIn and TikTok — depending on where your audience is most active and cost-effective for your sector.'),
(141, 71, 'fr', 'En combien de temps le SEO produit-il des résultats ?', 'Le SEO est un investissement moyen terme. La plupart des clients constatent des gains de positionnement significatifs en 3 à 6 mois, avec des retours qui s’accumulent dans le temps.'),
(142, 71, 'en', 'How soon can I expect results from SEO?', 'SEO is a medium-term investment. Most clients see meaningful ranking improvements within 3 to 6 months, with compounding returns over time.'),
(143, 72, 'fr', 'Pouvez-vous travailler avec notre équipe marketing interne ?', 'Oui. Nous complétons souvent les équipes internes — stratégie, paramétrage et optimisation de notre côté, community ou tonalité de marque de votre côté.'),
(144, 72, 'en', 'Can you work with our in-house marketing team?', 'Yes. We often complement internal teams — handling strategy, setup and optimization while your team manages day-to-day community or brand voice.'),
(151, 76, 'fr', 'Combien de temps dure une mission de stratégie digitale ?', 'La plupart des missions durent 3 à 6 semaines selon le périmètre — d’un sprint de positionnement ciblé à un plan go-to-market complet avec recommandations par canal.'),
(152, 76, 'en', 'How long does a digital strategy engagement take?', 'Most strategy projects run 3 to 6 weeks depending on scope — from a focused positioning sprint to a full go-to-market plan with channel recommendations.'),
(153, 77, 'fr', 'Travaillez-vous avec des startups et des entreprises établies ?', 'Oui. Nous adaptons notre méthodologie que vous validiez un nouveau produit, fassiez grandir une marque existante ou entriez sur un nouveau segment au Cameroun ou en Afrique de l’Ouest.'),
(154, 77, 'en', 'Do you work with startups and established companies?', 'Yes. We adapt our methodology whether you are validating a new product, scaling an existing brand or entering a new market segment in Cameroon or West Africa.'),
(155, 78, 'fr', 'Quels livrables vais-je recevoir ?', 'Vous recevez un brief stratégique, des personas, une priorisation des canaux, une structure de tableau de bord KPI et un plan d’exécution par phases utilisable par vos équipes internes ou prestataires.'),
(156, 78, 'en', 'What deliverables will I receive?', 'You receive a strategic brief, audience personas, channel prioritization, KPI dashboard structure and a phased execution plan your internal or external teams can follow.');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_sections`
--

CREATE TABLE `homepage_sections` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_sections`
--

INSERT INTO `homepage_sections` (`id`, `key`, `sort_order`, `is_active`) VALUES
(1, 'features', 0, 1),
(2, 'counters', 0, 1),
(3, 'leadership', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `size` int UNSIGNED NOT NULL DEFAULT '0',
  `disk` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'local',
  `folder` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'general',
  `alt_text` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `width` int DEFAULT NULL,
  `height` int DEFAULT NULL,
  `uploaded_by` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `filename`, `original_name`, `mime_type`, `size`, `disk`, `folder`, `alt_text`, `title`, `width`, `height`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(151, 'branding/favicon.png', 'favicon.png', 'image/png', 27791, 'local', 'branding', NULL, NULL, 1080, 1080, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(152, 'branding/logo.png', 'logo.png', 'image/png', 10894, 'local', 'branding', NULL, NULL, 949, 201, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(153, 'branding/w_logo.png', 'w_logo.png', 'image/png', 10894, 'local', 'branding', NULL, NULL, 949, 201, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(154, 'branding/w_logo02.png', 'w_logo02.png', 'image/png', 9560, 'local', 'branding', NULL, NULL, 949, 201, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(155, 'brand/brand_img01.png', 'brand_img01.png', 'image/jpeg', 204989, 'local', 'brand', NULL, NULL, 828, 609, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(156, 'brand/brand_img02.png', 'brand_img02.png', 'image/jpeg', 268302, 'local', 'brand', NULL, NULL, 979, 968, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(157, 'brand/brand_img03.png', 'brand_img03.png', 'image/png', 407649, 'local', 'brand', NULL, NULL, 1024, 1024, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(158, 'brand/brand_img04.png', 'brand_img04.png', 'image/png', 1548071, 'local', 'brand', NULL, NULL, 1024, 1024, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(159, 'brand/brand_img05.png', 'brand_img05.png', 'image/jpeg', 31800, 'local', 'brand', NULL, NULL, 715, 715, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(188, 'team/h9_team_shape01.png', 'h9_team_shape01.png', 'image/png', 2377, 'local', 'team', NULL, NULL, 88, 87, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(189, 'team/h9_team_shape02.png', 'h9_team_shape02.png', 'image/png', 6608, 'local', 'team', NULL, NULL, 392, 275, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(195, 'team/team_img_delphine.png', 'team_img_delphine.png', 'image/png', 119349, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(196, 'team/team_img_fabien.png', 'team_img_fabien.png', 'image/png', 153409, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(197, 'team/team_img_lionel.png', 'team_img_lionel.png', 'image/png', 149470, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(198, 'team/team_img_pascal.png', 'team_img_pascal.png', 'image/png', 111586, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(201, 'team/team_img_rose.png', 'team_img_rose.png', 'image/png', 133954, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(202, 'team/team_img_stephane.png', 'team_img_stephane.png', 'image/png', 134815, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(203, 'team/team_img_ulrich.png', 'team_img_ulrich.png', 'image/png', 129726, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(204, 'team/team_img_van.png', 'team_img_van.png', 'image/png', 155360, 'local', 'team', NULL, NULL, 284, 278, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(207, 'images/about_ceo.png', 'about_ceo.png', 'image/png', 10471, 'local', 'images', NULL, NULL, 70, 70, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(208, 'images/about_img01.png', 'about_img01.png', 'image/png', 1197, 'local', 'images', NULL, NULL, 312, 313, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(213, 'images/about_shape01.png', 'about_shape01.png', 'image/png', 879, 'local', 'images', NULL, NULL, 108, 112, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(214, 'images/about_shape02.png', 'about_shape02.png', 'image/png', 26303, 'local', 'images', NULL, NULL, 980, 495, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(215, 'images/breadcrumb_shape01.png', 'breadcrumb_shape01.png', 'image/png', 4454, 'local', 'images', NULL, NULL, 488, 134, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(216, 'images/breadcrumb_shape02.png', 'breadcrumb_shape02.png', 'image/png', 1663, 'local', 'images', NULL, NULL, 159, 59, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(221, 'images/contact_img_baf.png', 'contact_img_baf.png', 'image/png', 837753, 'local', 'images', NULL, NULL, 600, 579, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(222, 'images/contact_img_dla.png', 'contact_img_dla.png', 'image/png', 837753, 'local', 'images', NULL, NULL, 600, 579, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(223, 'images/contact_img_yde.png', 'contact_img_yde.png', 'image/png', 868683, 'local', 'images', NULL, NULL, 600, 579, NULL, '2026-06-08 17:27:26', '2026-06-08 17:27:26'),
(244, 'images/h2_about_shape01.png', 'h2_about_shape01.png', 'image/png', 879, 'local', 'images', NULL, NULL, 108, 112, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(245, 'images/h2_about_shape02.png', 'h2_about_shape02.png', 'image/png', 2858, 'local', 'images', NULL, NULL, 156, 156, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(246, 'blog/avatar.png', 'avatar.png', 'image/png', 431, 'local', 'blog', NULL, NULL, 115, 115, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(249, 'blog/blog_avatar01.png', 'blog_avatar01.png', 'image/png', 244, 'local', 'blog', NULL, NULL, 40, 40, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(250, 'blog/blog_avatar02.png', 'blog_avatar02.png', 'image/png', 244, 'local', 'blog', NULL, NULL, 40, 40, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(251, 'blog/blog_avatar03.png', 'blog_avatar03.png', 'image/png', 244, 'local', 'blog', NULL, NULL, 40, 40, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(255, 'blog/blog_img01.jpg', 'blog_img01.jpg', 'image/png', 2164, 'local', 'blog', NULL, NULL, 392, 260, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(256, 'blog/blog_img02.jpg', 'blog_img02.jpg', 'image/png', 2164, 'local', 'blog', NULL, NULL, 392, 260, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(257, 'blog/blog_img03.jpg', 'blog_img03.jpg', 'image/png', 2164, 'local', 'blog', NULL, NULL, 392, 260, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(263, 'blog/h3_blog_img01.jpg', 'h3_blog_img01.jpg', 'image/png', 2164, 'local', 'blog', NULL, NULL, 392, 260, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(264, 'blog/h3_blog_img02.jpg', 'h3_blog_img02.jpg', 'image/png', 2164, 'local', 'blog', NULL, NULL, 392, 260, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(265, 'blog/h3_blog_img03.jpg', 'h3_blog_img03.jpg', 'image/png', 2164, 'local', 'blog', NULL, NULL, 392, 260, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(274, 'services/h4_services_img01.jpg', 'h4_services_img01.jpg', 'image/png', 1399, 'local', 'services', NULL, NULL, 288, 180, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(275, 'services/h4_services_img02.jpg', 'h4_services_img02.jpg', 'image/png', 1399, 'local', 'services', NULL, NULL, 288, 180, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(276, 'services/h4_services_img03.jpg', 'h4_services_img03.jpg', 'image/png', 1399, 'local', 'services', NULL, NULL, 288, 180, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(277, 'services/h4_services_img04.jpg', 'h4_services_img04.jpg', 'image/png', 1399, 'local', 'services', NULL, NULL, 288, 180, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(283, 'services/h6_services_shape01.png', 'h6_services_shape01.png', 'image/png', 11522, 'local', 'services', NULL, NULL, 749, 544, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(284, 'services/h6_services_shape02.png', 'h6_services_shape02.png', 'image/png', 13296, 'local', 'services', NULL, NULL, 776, 552, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(293, 'projects/h5_project_img01.jpg', 'h5_project_img01.jpg', 'image/jpeg', 33302, 'local', 'projects', NULL, NULL, 600, 340, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(294, 'projects/h5_project_img02.jpg', 'h5_project_img02.jpg', 'image/jpeg', 36280, 'local', 'projects', NULL, NULL, 600, 340, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(295, 'projects/h5_project_img03.jpg', 'h5_project_img03.jpg', 'image/jpeg', 19983, 'local', 'projects', NULL, NULL, 392, 340, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(296, 'projects/h5_project_img04.jpg', 'h5_project_img04.jpg', 'image/jpeg', 22165, 'local', 'projects', NULL, NULL, 392, 340, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27'),
(297, 'projects/h5_project_img05.jpg', 'h5_project_img05.jpg', 'image/jpeg', 12885, 'local', 'projects', NULL, NULL, 392, 340, NULL, '2026-06-08 17:27:27', '2026-06-08 17:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `media_translations`
--

CREATE TABLE `media_translations` (
  `id` int UNSIGNED NOT NULL,
  `media_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `caption` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `key`, `name`) VALUES
(1, 'header', 'Header Navigation');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int UNSIGNED NOT NULL,
  `menu_id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'url',
  `target_id` int UNSIGNED DEFAULT NULL,
  `url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `css_class` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `open_new_tab` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `sort_order`, `type`, `target_id`, `url`, `icon`, `css_class`, `is_active`, `open_new_tab`) VALUES
(31, 1, NULL, 1, 'route', NULL, 'home', NULL, '', 1, 0),
(32, 1, NULL, 2, 'route', NULL, 'about', NULL, '', 1, 0),
(33, 1, NULL, 3, 'route', NULL, 'services', NULL, '', 1, 0),
(34, 1, NULL, 4, 'route', NULL, 'projects', NULL, '', 1, 0),
(35, 1, NULL, 5, 'route', NULL, 'contact', NULL, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_translations`
--

CREATE TABLE `menu_item_translations` (
  `id` int UNSIGNED NOT NULL,
  `menu_item_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item_translations`
--

INSERT INTO `menu_item_translations` (`id`, `menu_item_id`, `locale`, `label`) VALUES
(61, 31, 'fr', 'Accueil'),
(62, 31, 'en', 'Home'),
(63, 32, 'fr', 'À Propos'),
(64, 32, 'en', 'About Us'),
(65, 33, 'fr', 'Services'),
(66, 33, 'en', 'Services'),
(67, 34, 'fr', 'Projets'),
(68, 34, 'en', 'Projects'),
(69, 35, 'fr', 'Contact'),
(70, 35, 'en', 'Contact');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1780931124, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1780931124, 1),
(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1780931124, 1),
(4, '2026-06-08-100000', 'App\\Database\\Migrations\\CreateLegacyFormTables', 'default', 'App', 1780931125, 1),
(5, '2026-06-08-100100', 'App\\Database\\Migrations\\CreateCmsCoreTables', 'default', 'App', 1780931126, 1),
(6, '2026-06-08-100200', 'App\\Database\\Migrations\\CreateContentTables', 'default', 'App', 1780931127, 1),
(7, '2026-06-08-120000', 'App\\Database\\Migrations\\CreateAdminActivityLog', 'default', 'App', 1780931127, 1),
(8, '2026-06-08-130000', 'App\\Database\\Migrations\\CreateSiteSettingsTable', 'default', 'App', 1780931957, 2),
(9, '2026-06-08-140000', 'App\\Database\\Migrations\\CreateQuoteDocumentsTable', 'default', 'App', 1780932324, 3),
(10, '2026-06-08-170000', 'App\\Database\\Migrations\\AddSortOrderToBlogPosts', 'default', 'App', 1780938277, 4),
(11, '2026-06-09-100000', 'App\\Database\\Migrations\\AddAdminBrandingToSiteBranding', 'default', 'App', 1781002856, 5),
(12, '2026-06-09-120000', 'App\\Database\\Migrations\\SeedIntegrationSettings', 'default', 'App', 1781005195, 6),
(13, '2026-06-09-140000', 'App\\Database\\Migrations\\AddTinyMceApiKeySetting', 'default', 'App', 1781006080, 7),
(14, '2026-06-09-130000', 'App\\Database\\Migrations\\AddAssetsMinifiedSetting', 'default', 'App', 1781007189, 8),
(15, '2026-06-09-150000', 'App\\Database\\Migrations\\AddRecaptchaSecretKeySetting', 'default', 'App', 1781076265, 9),
(16, '2026-06-10-100000', 'App\\Database\\Migrations\\AddMissingTranslationColumns', 'default', 'App', 1781078668, 10);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lang` char(2) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'fr',
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `status` enum('active','unsubscribed') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `office_locations`
--

CREATE TABLE `office_locations` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_locations`
--

INSERT INTO `office_locations` (`id`, `email`, `phone`, `lat`, `lng`, `image`, `sort_order`, `is_active`) VALUES
(1, 'douala@dbdigitalagency.com', '+237 658 910 343', 4.0488390, 9.7044970, 'contact_img_dla.png', 1, 1),
(2, 'yaounde@dbdigitalagency.com', '+237 691 323 249', 3.8514329, 11.5765658, 'contact_img_yde.png', 2, 1),
(3, 'bafoussam@dbdigitalagency.com', '+237 640 819 846', 5.5000070, 10.3887600, 'contact_img_baf.png', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `office_location_translations`
--

CREATE TABLE `office_location_translations` (
  `id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `label` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_location_translations`
--

INSERT INTO `office_location_translations` (`id`, `location_id`, `locale`, `city`, `address`, `label`) VALUES
(1, 1, 'fr', 'Douala', 'Cité des palmiers', 'Cameroun · Douala'),
(2, 1, 'en', 'Douala', 'Cité des palmiers', 'Cameroon · Douala'),
(3, 2, 'fr', 'Yaoundé', 'Nkoabang - Entrée Carrière', 'Cameroun · Yaoundé'),
(4, 2, 'en', 'Yaoundé', 'Nkoabang - Entrée Carrière', 'Cameroon · Yaoundé'),
(5, 3, 'fr', 'Bafoussam', 'Kamkop (face station Tradex)', 'Cameroun · Bafoussam'),
(6, 3, 'en', 'Bafoussam', 'Kamkop (face station Tradex)', 'Cameroon · Bafoussam');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int UNSIGNED NOT NULL,
  `template` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `created_by` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `template`, `sort_order`, `is_published`, `published_at`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'about', 1, 1, '2026-06-08 15:19:41', NULL, NULL, NULL),
(2, 'contact', 2, 1, '2026-06-08 15:19:41', NULL, NULL, NULL),
(3, 'legal', 3, 1, '2026-06-09 11:39:55', NULL, NULL, NULL),
(4, 'legal', 3, 1, '2026-06-09 13:32:06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_translations`
--

CREATE TABLE `page_translations` (
  `id` int UNSIGNED NOT NULL,
  `page_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `content` longtext COLLATE utf8mb4_general_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `og_image_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_translations`
--

INSERT INTO `page_translations` (`id`, `page_id`, `locale`, `title`, `slug`, `excerpt`, `content`, `meta_title`, `meta_description`, `og_image_id`) VALUES
(1, 1, 'fr', 'À Propos', 'a-propos', '', '', 'À Propos | DB Digital Agency', '', NULL),
(2, 1, 'en', 'About Us', 'about', '', '', 'About Us | DB Digital Agency', '', NULL),
(3, 2, 'fr', 'Contact', 'contact', '', '', 'Contact | DB Digital Agency', '', NULL),
(4, 2, 'en', 'Contact', 'contact', '', '', 'Contact | DB Digital Agency', '', NULL),
(5, 3, 'fr', 'Politique de confidentialité', 'politique-confidentialite', 'Comment nous collectons, utilisons et protégeons vos données personnelles.', '<div class=\"legal-section\" id=\"responsable\">\n<h2>1. Responsable du traitement</h2>\n<p><strong>DB Digital Agency</strong> est responsable du traitement des données collectées via ce site. Contact : <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"donnees-collectees\">\n<h2>2. Données collectées</h2>\n<p>Selon vos interactions, nous pouvons traiter :</p>\n<ul class=\"legal-list\">\n<li><strong>Formulaire de contact</strong> — nom, téléphone, email, message</li>\n<li><strong>Demande de devis</strong> — coordonnées, détails du projet, pièces jointes éventuelles</li>\n<li><strong>Newsletter</strong> — adresse email</li>\n<li><strong>Espace devis client</strong> — email et données liées à votre demande</li>\n<li><strong>Données techniques</strong> — logs, adresse IP, navigateur (sécurité et statistiques)</li>\n</ul>\n</div>\n\n<div class=\"legal-section\" id=\"finalites\">\n<h2>3. Finalités</h2>\n<ul class=\"legal-list\">\n<li>Répondre à vos demandes et assurer le suivi commercial</li>\n<li>Envoyer la newsletter (avec votre consentement)</li>\n<li>Améliorer le site, mesurer l\'audience et prévenir les abus</li>\n<li>Respecter nos obligations légales</li>\n</ul>\n</div>\n\n<div class=\"legal-section\" id=\"base-legale\">\n<h2>4. Base légale</h2>\n<p>Les traitements reposent sur l\'exécution de mesures précontractuelles, votre consentement (newsletter, cookies non essentiels), notre intérêt légitime (sécurité, amélioration du service) ou une obligation légale.</p>\n</div>\n\n<div class=\"legal-section\" id=\"conservation\">\n<h2>5. Durée de conservation</h2>\n<p>Les données de contact et devis sont conservées pendant la durée de la relation commerciale, puis archivées selon les délais légaux applicables. Les abonnés newsletter sont conservés jusqu\'à désinscription.</p>\n</div>\n\n<div class=\"legal-section\" id=\"cookies\">\n<h2>6. Cookies & mesure d\'audience</h2>\n<p>Des cookies peuvent être déposés après votre consentement via le bandeau cookies :</p>\n<ul class=\"legal-list\">\n<li>Mesure d\'audience (ex. Google Analytics 4, Microsoft Clarity, Hotjar)</li>\n<li>Outils marketing (ex. Meta Pixel, LinkedIn Insight Tag)</li>\n<li>Google Tag Manager pour la gestion des balises</li>\n</ul>\n<p>Vous pouvez refuser les cookies non essentiels ou retirer votre consentement à tout moment via les paramètres de votre navigateur.</p>\n</div>\n\n<div class=\"legal-section\" id=\"securite\">\n<h2>7. Sécurité</h2>\n<p>Nous mettons en œuvre des mesures techniques et organisationnelles : chiffrement HTTPS, limitation du débit sur les formulaires, reCAPTCHA v3, honeypot anti-spam et accès restreint aux données.</p>\n</div>\n\n<div class=\"legal-section\" id=\"droits\">\n<h2>8. Vos droits</h2>\n<p>Vous disposez d\'un droit d\'accès, de rectification, d\'effacement, de limitation, d\'opposition et de portabilité lorsque applicable. Pour exercer vos droits : <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"transferts\">\n<h2>9. Transferts & sous-traitants</h2>\n<p>Certains outils (hébergement, email, analytics) peuvent impliquer des sous-traitants situés hors du Cameroun, avec des garanties appropriées lorsque requis.</p>\n</div>\n\n<div class=\"legal-section\" id=\"mentions\">\n<h2>10. Mentions légales</h2>\n<p>Consultez également nos <a href=\"/fr/mentions-legales\">mentions légales</a>.</p>\n<p class=\"legal-muted\">Dernière mise à jour : 2026.</p>\n</div>', 'Politique de confidentialité | DB Digital Agency', 'Politique de confidentialité DB Digital Agency : formulaires, cookies, analytics, vos droits RGPD et contact.', NULL),
(6, 3, 'en', 'Privacy policy', 'privacy-policy', 'How we collect, use and protect your personal data.', '<div class=\"legal-section\" id=\"controller\">\n<h2>1. Data controller</h2>\n<p><strong>DB Digital Agency</strong> is the data controller for information collected through this website. Contact: <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"data-collected\">\n<h2>2. Data we collect</h2>\n<p>Depending on your interactions, we may process:</p>\n<ul class=\"legal-list\">\n<li><strong>Contact form</strong> — name, phone, email, message</li>\n<li><strong>Quote request</strong> — contact details, project details, optional attachments</li>\n<li><strong>Newsletter</strong> — email address</li>\n<li><strong>Client quote portal</strong> — email and data related to your request</li>\n<li><strong>Technical data</strong> — logs, IP address, browser (security and analytics)</li>\n</ul>\n</div>\n\n<div class=\"legal-section\" id=\"purposes\">\n<h2>3. Purposes</h2>\n<ul class=\"legal-list\">\n<li>Respond to inquiries and manage commercial follow-up</li>\n<li>Send the newsletter (with your consent)</li>\n<li>Improve the site, measure traffic and prevent abuse</li>\n<li>Comply with legal obligations</li>\n</ul>\n</div>\n\n<div class=\"legal-section\" id=\"legal-basis\">\n<h2>4. Legal basis</h2>\n<p>Processing is based on pre-contractual steps, your consent (newsletter, non-essential cookies), our legitimate interest (security, service improvement) or legal obligation.</p>\n</div>\n\n<div class=\"legal-section\" id=\"retention\">\n<h2>5. Retention</h2>\n<p>Contact and quote data are kept for the business relationship duration, then archived per applicable legal periods. Newsletter subscribers are kept until unsubscribe.</p>\n</div>\n\n<div class=\"legal-section\" id=\"cookies\">\n<h2>6. Cookies & analytics</h2>\n<p>Cookies may be set after consent via our cookie banner:</p>\n<ul class=\"legal-list\">\n<li>Audience measurement (e.g. Google Analytics 4, Microsoft Clarity, Hotjar)</li>\n<li>Marketing tools (e.g. Meta Pixel, LinkedIn Insight Tag)</li>\n<li>Google Tag Manager for tag management</li>\n</ul>\n<p>You may refuse non-essential cookies or withdraw consent via your browser settings.</p>\n</div>\n\n<div class=\"legal-section\" id=\"security\">\n<h2>7. Security</h2>\n<p>We apply technical and organizational measures: HTTPS encryption, form rate limiting, reCAPTCHA v3, anti-spam honeypot and restricted data access.</p>\n</div>\n\n<div class=\"legal-section\" id=\"rights\">\n<h2>8. Your rights</h2>\n<p>You may request access, rectification, erasure, restriction, objection and portability where applicable. Contact: <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"processors\">\n<h2>9. Processors & transfers</h2>\n<p>Some tools (hosting, email, analytics) may involve processors outside Cameroon, with appropriate safeguards when required.</p>\n</div>\n\n<div class=\"legal-section\" id=\"legal-notice\">\n<h2>10. Legal notice</h2>\n<p>See also our <a href=\"/en/legal-notice\">legal notice</a>.</p>\n<p class=\"legal-muted\">Last updated: 2026.</p>\n</div>', 'Privacy policy | DB Digital Agency', 'DB Digital Agency privacy policy: forms, cookies, analytics, your rights and contact.', NULL),
(7, 4, 'fr', 'Mentions légales', 'mentions-legales', 'Informations légales relatives à l\'édition et à l\'utilisation du site dbdigitalagency.com.', '<div class=\"legal-section\" id=\"editeur\">\n<h2>1. Éditeur du site</h2>\n<p>Le site <strong>dbdigitalagency.com</strong> est édité par :</p>\n<ul class=\"legal-list\">\n<li><strong>Raison sociale :</strong> DB Digital Agency</li>\n<li><strong>Activité :</strong> Agence digitale — stratégie, design, développement web et marketing d\'acquisition</li>\n<li><strong>Siège & bureaux :</strong> Douala, Yaoundé et Bafoussam (Cameroun)</li>\n<li><strong>Email :</strong> <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a></li>\n<li><strong>Téléphone :</strong> +237 691 323 249</li>\n</ul>\n</div>\n\n<div class=\"legal-section\" id=\"publication\">\n<h2>2. Responsable de la publication</h2>\n<p>Le responsable de la publication est la direction de DB Digital Agency, joignable à l\'adresse <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"hebergement\">\n<h2>3. Hébergement</h2>\n<p>Le site est hébergé par un prestataire professionnel dont les coordonnées peuvent être communiquées sur demande à <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"propriete\">\n<h2>4. Propriété intellectuelle</h2>\n<p>L\'ensemble des éléments du site (textes, visuels, logos, charte graphique, code, structure) est protégé par le droit de la propriété intellectuelle. Toute reproduction, représentation ou exploitation non autorisée est interdite sans accord écrit préalable de DB Digital Agency.</p>\n<p>Les marques et logos de tiers mentionnés restent la propriété de leurs titulaires respectifs.</p>\n</div>\n\n<div class=\"legal-section\" id=\"responsabilite\">\n<h2>5. Limitation de responsabilité</h2>\n<p>DB Digital Agency s\'efforce d\'assurer l\'exactitude des informations publiées. Toutefois, nous ne saurions être tenus responsables des omissions, inexactitudes ou indisponibilités temporaires du service.</p>\n<p>Les liens vers des sites tiers n\'engagent pas la responsabilité éditoriale de DB Digital Agency.</p>\n</div>\n\n<div class=\"legal-section\" id=\"donnees\">\n<h2>6. Données personnelles</h2>\n<p>Le traitement des données personnelles est décrit dans notre <a href=\"/fr/politique-confidentialite\">politique de confidentialité</a>. Pour toute question : <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"droit\">\n<h2>7. Droit applicable</h2>\n<p>Les présentes mentions sont régies par le droit en vigueur au Cameroun. En cas de litige, une solution amiable sera recherchée avant toute action judiciaire.</p>\n<p class=\"legal-muted\">Dernière mise à jour : 2026.</p>\n</div>', 'Mentions légales | DB Digital Agency', 'Mentions légales de DB Digital Agency : éditeur, contact, hébergement, propriété intellectuelle et droit applicable au Cameroun.', NULL),
(8, 4, 'en', 'Legal notice', 'legal-notice', 'Legal information about the publication and use of dbdigitalagency.com.', '<div class=\"legal-section\" id=\"publisher\">\n<h2>1. Site publisher</h2>\n<p>The website <strong>dbdigitalagency.com</strong> is published by:</p>\n<ul class=\"legal-list\">\n<li><strong>Company name:</strong> DB Digital Agency</li>\n<li><strong>Activity:</strong> Digital agency — strategy, design, web development and growth marketing</li>\n<li><strong>Offices:</strong> Douala, Yaoundé and Bafoussam (Cameroon)</li>\n<li><strong>Email:</strong> <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a></li>\n<li><strong>Phone:</strong> +237 691 323 249</li>\n</ul>\n</div>\n\n<div class=\"legal-section\" id=\"publication\">\n<h2>2. Publication director</h2>\n<p>The publication director is the management of DB Digital Agency, reachable at <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"hosting\">\n<h2>3. Hosting</h2>\n<p>The site is hosted by a professional provider; details are available upon request at <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"ip\">\n<h2>4. Intellectual property</h2>\n<p>All site elements (text, visuals, logos, branding, code, structure) are protected by intellectual property law. Any unauthorized reproduction or use requires prior written consent from DB Digital Agency.</p>\n<p>Third-party trademarks and logos remain the property of their respective owners.</p>\n</div>\n\n<div class=\"legal-section\" id=\"liability\">\n<h2>5. Limitation of liability</h2>\n<p>DB Digital Agency strives to keep published information accurate. We cannot be held liable for omissions, inaccuracies or temporary unavailability.</p>\n<p>Links to third-party websites do not imply editorial responsibility by DB Digital Agency.</p>\n</div>\n\n<div class=\"legal-section\" id=\"privacy-link\">\n<h2>6. Personal data</h2>\n<p>Personal data processing is described in our <a href=\"/en/privacy-policy\">privacy policy</a>. Questions: <a href=\"mailto:contact@dbdigitalagency.com\">contact@dbdigitalagency.com</a>.</p>\n</div>\n\n<div class=\"legal-section\" id=\"law\">\n<h2>7. Applicable law</h2>\n<p>This legal notice is governed by the laws of Cameroon. Disputes will first be addressed through good-faith negotiation.</p>\n<p class=\"legal-muted\">Last updated: 2026.</p>\n</div>', 'Legal notice | DB Digital Agency', 'DB Digital Agency legal notice: publisher, contact, hosting, intellectual property and applicable law in Cameroon.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `col_lg` tinyint NOT NULL DEFAULT '4',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `slug`, `image`, `col_lg`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'illustration-design', 'h5_project_img01.jpg', 6, 1, 1, NULL, NULL),
(2, 'design-development', 'h5_project_img02.jpg', 6, 2, 1, NULL, NULL),
(3, 'marketing-consultancy', 'h5_project_img03.jpg', 4, 3, 1, NULL, NULL),
(4, 'digital-marketing', 'h5_project_img04.jpg', 4, 4, 1, NULL, NULL),
(5, 'strategic-planning', 'h5_project_img05.jpg', 4, 5, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_translations`
--

CREATE TABLE `project_translations` (
  `id` int UNSIGNED NOT NULL,
  `project_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `client` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_translations`
--

INSERT INTO `project_translations` (`id`, `project_id`, `locale`, `title`, `category`, `description`, `client`) VALUES
(1, 1, 'fr', 'Design d\'Illustration', 'Travail Créatif', '', NULL),
(2, 1, 'en', 'Illustration Design', 'Creative Work', '', NULL),
(3, 2, 'fr', 'Design & Développement', 'Planification', '', NULL),
(4, 2, 'en', 'Design & Development', 'Planing', '', NULL),
(5, 3, 'fr', 'Conseil en Marketing', 'Développement', '', NULL),
(6, 3, 'en', 'Marketing Consultancy', 'Development', '', NULL),
(7, 4, 'fr', 'Marketing Digital', 'Développement de Compétences', '', NULL),
(8, 4, 'en', 'Digital Marketing', 'Skill Development', '', NULL),
(9, 5, 'fr', 'Planification Stratégique', 'Marketing', '', NULL),
(10, 5, 'en', 'Strategic Planning', 'Marketing', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prospect_activity_logs`
--

CREATE TABLE `prospect_activity_logs` (
  `id` int UNSIGNED NOT NULL,
  `quote_id` int UNSIGNED NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int UNSIGNED NOT NULL,
  `service` text COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `budget` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `brief_file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `access_token` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `last_accessed_at` datetime DEFAULT NULL,
  `status` enum('new','contacted','in_progress','completed','cancelled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'new',
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote_documents`
--

CREATE TABLE `quote_documents` (
  `id` int UNSIGNED NOT NULL,
  `quote_id` int UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote_logs`
--

CREATE TABLE `quote_logs` (
  `id` int UNSIGNED NOT NULL,
  `quote_id` int UNSIGNED NOT NULL,
  `action_type` enum('email_sent','whatsapp_click','email_failed','prospect_access','status_change','document_upload') COLLATE utf8mb4_general_ci NOT NULL,
  `action_details` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote_services`
--

CREATE TABLE `quote_services` (
  `id` int UNSIGNED NOT NULL,
  `quote_id` int UNSIGNED NOT NULL,
  `service_key` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_translations`
--

CREATE TABLE `section_translations` (
  `id` int UNSIGNED NOT NULL,
  `section_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_translations`
--

INSERT INTO `section_translations` (`id`, `section_id`, `locale`, `data`) VALUES
(1, 1, 'fr', '{\"items\": [{\"desc\": \"Stratégie et parcours pensés conversion.\", \"icon\": \"flaticon-layers\", \"title_key\": \"features_growing\"}, {\"desc\": \"Acquisition optimisée pour le ROI.\", \"icon\": \"flaticon-mission\", \"title_key\": \"features_finance\"}, {\"desc\": \"Marque et UX qui rassurent vite.\", \"icon\": \"flaticon-profit\", \"title_key\": \"features_tax\"}]}'),
(2, 1, 'en', '{\"items\": [{\"desc\": \"Strategy and journeys built to convert.\", \"icon\": \"flaticon-layers\", \"title_key\": \"features_growing\"}, {\"desc\": \"Acquisition systems optimized for ROI.\", \"icon\": \"flaticon-mission\", \"title_key\": \"features_finance\"}, {\"desc\": \"Brand and UX that build trust fast.\", \"icon\": \"flaticon-profit\", \"title_key\": \"features_tax\"}]}'),
(3, 2, 'fr', '[{\"icon\": \"flaticon-folder-1\", \"count\": 9525, \"label_key\": \"counter_projects\"}, {\"icon\": \"flaticon-rating\", \"count\": 11985, \"label_key\": \"counter_clients\"}, {\"icon\": \"flaticon-trophy\", \"count\": 4722, \"label_key\": \"counter_awards\"}, {\"icon\": \"flaticon-puzzle-piece\", \"count\": 115, \"label_key\": \"counter_countries\"}]'),
(4, 2, 'en', '[{\"icon\": \"flaticon-folder-1\", \"count\": 9525, \"label_key\": \"counter_projects\"}, {\"icon\": \"flaticon-rating\", \"count\": 11985, \"label_key\": \"counter_clients\"}, {\"icon\": \"flaticon-trophy\", \"count\": 4722, \"label_key\": \"counter_awards\"}, {\"icon\": \"flaticon-puzzle-piece\", \"count\": 115, \"label_key\": \"counter_countries\"}]'),
(5, 3, 'fr', '{\"ceo_name\": \"Eugénie Rose Yuoyang\", \"ceo_image\": \"about_ceo.png\", \"signature_image\": \"signature.png\", \"experience_years\": \"15+\"}'),
(6, 3, 'en', '{\"ceo_name\": \"Eugénie Rose Yuoyang\", \"ceo_image\": \"about_ceo.png\", \"signature_image\": \"signature.png\", \"experience_years\": \"15+\"}');

-- --------------------------------------------------------

--
-- Table structure for table `seo_meta`
--

CREATE TABLE `seo_meta` (
  `id` int UNSIGNED NOT NULL,
  `entity_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `entity_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_keywords` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `og_description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `og_image_id` int UNSIGNED DEFAULT NULL,
  `canonical_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `robots` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'index,follow',
  `schema_json` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seo_meta`
--

INSERT INTO `seo_meta` (`id`, `entity_type`, `entity_id`, `locale`, `meta_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `og_image_id`, `canonical_url`, `robots`, `schema_json`) VALUES
(1, 'home', 1, 'fr', 'Agence digitale au Cameroun', 'DB Digital Agency - Stratégie, design, développement web et marketing d’acquisition pour les entreprises ambitieuses au Cameroun.', 'agence digitale, cameroun, yaoundé, douala, stratégie digitale, marketing', 'Agence digitale au Cameroun', 'DB Digital Agency - Stratégie, design, développement web et marketing d’acquisition pour les entreprises ambitieuses au Cameroun.', NULL, 'http://localhost/dbdigitalagency/public/fr', 'index,follow', NULL),
(2, 'home', 1, 'en', 'Digital agency in Cameroon', 'DB Digital Agency - Strategy, design, web development and growth marketing for ambitious businesses in Cameroon.', 'digital agency, cameroon, yaounde, douala, digital strategy, marketing', 'Digital agency in Cameroon', 'DB Digital Agency - Strategy, design, web development and growth marketing for ambitious businesses in Cameroon.', NULL, 'http://localhost/dbdigitalagency/public/en', 'index,follow', NULL),
(3, 'contact', 1, 'fr', 'Parlons de votre projet', 'Envoyez-nous un message ou repérez nos bureaux sur la carte — nous vous répondons rapidement.', 'contact agence digitale, devis, douala, yaoundé, bafoussam', 'Parlons de votre projet', 'Envoyez-nous un message ou repérez nos bureaux sur la carte — nous vous répondons rapidement.', NULL, 'http://localhost/dbdigitalagency/public/fr/contact', 'index,follow', NULL),
(4, 'contact', 1, 'en', 'Let\'s talk about your project', 'Send us a message or find our offices on the map — we respond quickly.', 'contact digital agency, quote, douala, yaounde, bafoussam', 'Let\'s talk about your project', 'Send us a message or find our offices on the map — we respond quickly.', NULL, 'http://localhost/dbdigitalagency/public/en/contact', 'index,follow', NULL),
(5, 'quote', 1, 'fr', 'Demandez un Devis', 'Parlez-nous de votre projet et nous vous proposerons une proposition adaptée à vos objectifs.', 'devis site web, devis agence digitale, cameroun', 'Demandez un Devis', 'Parlez-nous de votre projet et nous vous proposerons une proposition adaptée à vos objectifs.', NULL, 'http://localhost/dbdigitalagency/public/fr/devis', 'index,follow', NULL),
(6, 'quote', 1, 'en', 'Request a Quote', 'Tell us about your project and we will provide a tailored proposal that fits your goals.', 'website quote, digital agency quote, cameroon', 'Request a Quote', 'Tell us about your project and we will provide a tailored proposal that fits your goals.', NULL, 'http://localhost/dbdigitalagency/public/en/get-quote', 'index,follow', NULL),
(7, 'blog', 1, 'fr', 'Analyses & Conseils', 'Articles actionnables sur la stratégie, le design, le web, le SEO et l’acquisition pour les entreprises au Cameroun.', 'blog digital, seo, marketing cameroun, stratégie digitale', 'Analyses & Conseils', 'Articles actionnables sur la stratégie, le design, le web, le SEO et l’acquisition pour les entreprises au Cameroun.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog', 'index,follow', NULL),
(8, 'blog', 1, 'en', 'Insights', 'Actionable articles on strategy, design, web, SEO and acquisition for businesses in Cameroon.', 'digital blog, seo, marketing cameroon, digital strategy', 'Insights', 'Actionable articles on strategy, design, web, SEO and acquisition for businesses in Cameroon.', NULL, 'http://localhost/dbdigitalagency/public/en/blog', 'index,follow', NULL),
(9, 'project', 1, 'fr', 'Projets', 'Nous avons aidé des marques à croître grâce à des solutions digitales solides', 'projets digitaux, portfolio, agence digitale cameroun', 'Projets', 'Nous avons aidé des marques à croître grâce à des solutions digitales solides', NULL, 'http://localhost/dbdigitalagency/public/fr/projets', 'index,follow', NULL),
(10, 'project', 1, 'en', 'Projects', 'We have helped brands grow with strong digital solutions', 'digital projects, portfolio, digital agency cameroon', 'Projects', 'We have helped brands grow with strong digital solutions', NULL, 'http://localhost/dbdigitalagency/public/en/projects', 'index,follow', NULL),
(11, 'services_index', 1, 'fr', 'Nos Services', 'De la stratégie à l’exécution : design, développement et marketing d’acquisition pour une présence digitale forte et des résultats mesurables.', 'services digitaux, web, branding, marketing, cameroun', 'Nos Services', 'De la stratégie à l’exécution : design, développement et marketing d’acquisition pour une présence digitale forte et des résultats mesurables.', NULL, 'http://localhost/dbdigitalagency/public/fr/services', 'index,follow', NULL),
(12, 'services_index', 1, 'en', 'Our Services', 'From strategy to execution: design, development and growth marketing to build a strong digital presence and measurable results.', 'digital services, web, branding, marketing, cameroon', 'Our Services', 'From strategy to execution: design, development and growth marketing to build a strong digital presence and measurable results.', NULL, 'http://localhost/dbdigitalagency/public/en/services', 'index,follow', NULL),
(13, 'page', 1, 'fr', 'Innovation et croissance pour les entreprises digitales', 'Nous sommes une agence digitale basée à Yaoundé, aidant les entreprises à créer des marques fortes, à convertir davantage de clients et à croître grâce à des expériences digitales performantes.', 'à propos, agence digitale yaoundé, équipe, cameroun', 'Innovation et croissance pour les entreprises digitales', 'Nous sommes une agence digitale basée à Yaoundé, aidant les entreprises à créer des marques fortes, à convertir davantage de clients et à croître grâce à des expériences digitales performantes.', NULL, 'http://localhost/dbdigitalagency/public/fr/a-propos', 'index,follow', NULL),
(14, 'page', 1, 'en', 'Innovation and growth for digital businesses', 'We are a Yaoundé-based digital agency helping businesses create strong online brands, convert more customers and scale through high-performance digital experiences.', 'about us, digital agency yaounde, team, cameroon', 'Innovation and growth for digital businesses', 'We are a Yaoundé-based digital agency helping businesses create strong online brands, convert more customers and scale through high-performance digital experiences.', NULL, 'http://localhost/dbdigitalagency/public/en/about', 'index,follow', NULL),
(15, 'page', 3, 'en', 'Privacy policy', 'How we collect, use and protect your personal data.', 'legal notice, privacy, gdpr, cameroon', 'Privacy policy', 'How we collect, use and protect your personal data.', NULL, 'http://localhost/dbdigitalagency/public/en/privacy-policy', 'index,follow', NULL),
(16, 'page', 3, 'fr', 'Politique de confidentialité', 'Comment nous collectons, utilisons et protégeons vos données personnelles.', 'mentions légales, confidentialité, rgpd, cameroun', 'Politique de confidentialité', 'Comment nous collectons, utilisons et protégeons vos données personnelles.', NULL, 'http://localhost/dbdigitalagency/public/fr/politique-confidentialite', 'index,follow', NULL),
(17, 'service', 1, 'en', 'Digital Strategy', 'Positioning, messaging, customer journey and a clear execution plan to hit growth targets.', 'digital strategy, marketing, digital audit, digital agency, cameroon, yaounde, douala', 'Digital Strategy', 'Positioning, messaging, customer journey and a clear execution plan to hit growth targets.', NULL, 'http://localhost/dbdigitalagency/public/en/services/digital-strategy', 'index,follow', NULL),
(18, 'service', 1, 'fr', 'Stratégie Digitale', 'Positionnement, message, parcours client et plan d’exécution clair pour atteindre vos objectifs.', 'stratégie digitale, marketing, audit digital, agence digitale, cameroun, yaoundé, douala', 'Stratégie Digitale', 'Positionnement, message, parcours client et plan d’exécution clair pour atteindre vos objectifs.', NULL, 'http://localhost/dbdigitalagency/public/fr/services/digital-strategy', 'index,follow', NULL),
(19, 'service', 2, 'en', 'Web Development', 'Fast, secure websites and web apps built for performance, SEO and conversion.', 'web development, website, application, digital agency, cameroon, yaounde, douala', 'Web Development', 'Fast, secure websites and web apps built for performance, SEO and conversion.', NULL, 'http://localhost/dbdigitalagency/public/en/services/web-development', 'index,follow', NULL),
(20, 'service', 2, 'fr', 'Développement Web', 'Sites et applications web rapides et sécurisés, pensés performance, SEO et conversion.', 'développement web, site internet, application, agence digitale, cameroun, yaoundé, douala', 'Développement Web', 'Sites et applications web rapides et sécurisés, pensés performance, SEO et conversion.', NULL, 'http://localhost/dbdigitalagency/public/fr/services/web-development', 'index,follow', NULL),
(21, 'service', 3, 'en', 'Branding & UI/UX', 'Brand identity and product design that build trust and make people take action.', 'branding, visual identity, ui ux, digital agency, cameroon, yaounde, douala', 'Branding & UI/UX', 'Brand identity and product design that build trust and make people take action.', NULL, 'http://localhost/dbdigitalagency/public/en/services/branding', 'index,follow', NULL),
(22, 'service', 3, 'fr', 'Branding & UI/UX', 'Identité de marque et design produit pour renforcer la confiance et déclencher l’action.', 'branding, identité visuelle, ui ux, agence digitale, cameroun, yaoundé, douala', 'Branding & UI/UX', 'Identité de marque et design produit pour renforcer la confiance et déclencher l’action.', NULL, 'http://localhost/dbdigitalagency/public/fr/services/branding', 'index,follow', NULL),
(23, 'service', 4, 'en', 'Growth Marketing', 'SEO, paid media and content systems that consistently generate qualified leads.', 'digital marketing, acquisition, advertising, digital agency, cameroon, yaounde, douala', 'Growth Marketing', 'SEO, paid media and content systems that consistently generate qualified leads.', NULL, 'http://localhost/dbdigitalagency/public/en/services/marketing', 'index,follow', NULL),
(24, 'service', 4, 'fr', 'Marketing d’Acquisition', 'SEO, publicité et contenus qui génèrent des prospects qualifiés de façon régulière.', 'marketing digital, acquisition, publicité, agence digitale, cameroun, yaoundé, douala', 'Marketing d’Acquisition', 'SEO, publicité et contenus qui génèrent des prospects qualifiés de façon régulière.', NULL, 'http://localhost/dbdigitalagency/public/fr/services/marketing', 'index,follow', NULL),
(25, 'blog_post', 1, 'en', 'How to Launch a Strong Digital Brand in Cameroon', 'Step-by-step guidance to build an impactful digital brand for local audiences.', 'digital blog, how to launch a strong digital brand in cameroon, cameroon', 'How to Launch a Strong Digital Brand in Cameroon', 'Step-by-step guidance to build an impactful digital brand for local audiences.', NULL, 'http://localhost/dbdigitalagency/public/en/blog/how-to-launch-a-strong-digital-brand-in-cameroon', 'index,follow', NULL),
(26, 'blog_post', 1, 'fr', 'Comment Lancer une Marque Digitale Forte au Cameroun', 'Guide étape par étape pour construire une marque digitale forte adaptée au marché camerounais.', 'blog digital, comment lancer une marque digitale forte au cameroun, cameroun', 'Comment Lancer une Marque Digitale Forte au Cameroun', 'Guide étape par étape pour construire une marque digitale forte adaptée au marché camerounais.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog/how-to-launch-a-strong-digital-brand-in-cameroon', 'index,follow', NULL),
(27, 'blog_post', 2, 'en', 'Digital Transformation for African SMEs', 'How small and medium businesses in Cameroon can thrive with the right digital tools.', 'digital blog, digital transformation for african smes, cameroon', 'Digital Transformation for African SMEs', 'How small and medium businesses in Cameroon can thrive with the right digital tools.', NULL, 'http://localhost/dbdigitalagency/public/en/blog/digital-transformation-for-african-smes', 'index,follow', NULL),
(28, 'blog_post', 2, 'fr', 'Transformation Digitale pour les PME Africaines', 'Comment les petites et moyennes entreprises camerounaises peuvent prospérer avec les bons outils digitaux.', 'blog digital, transformation digitale pour les pme africaines, cameroun', 'Transformation Digitale pour les PME Africaines', 'Comment les petites et moyennes entreprises camerounaises peuvent prospérer avec les bons outils digitaux.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog/digital-transformation-for-african-smes', 'index,follow', NULL),
(29, 'blog_post', 3, 'en', 'Growth Marketing for Startups in Cameroon', 'Performance marketing tactics to turn traffic into paying customers.', 'digital blog, growth marketing for startups in cameroon, cameroon', 'Growth Marketing for Startups in Cameroon', 'Performance marketing tactics to turn traffic into paying customers.', NULL, 'http://localhost/dbdigitalagency/public/en/blog/growth-marketing-for-startups-in-cameroon', 'index,follow', NULL),
(30, 'blog_post', 3, 'fr', 'Marketing de Croissance pour les Startups au Cameroun', 'Tactiques de marketing de performance pour transformer le trafic en clients payants.', 'blog digital, marketing de croissance pour les startups au cameroun, cameroun', 'Marketing de Croissance pour les Startups au Cameroun', 'Tactiques de marketing de performance pour transformer le trafic en clients payants.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog/growth-marketing-for-startups-in-cameroon', 'index,follow', NULL),
(31, 'blog_post', 4, 'en', 'Website Conversion Best Practices', 'UX, copy and design techniques to increase leads and customer trust.', 'digital blog, website conversion best practices, cameroon', 'Website Conversion Best Practices', 'UX, copy and design techniques to increase leads and customer trust.', NULL, 'http://localhost/dbdigitalagency/public/en/blog/website-conversion-best-practices', 'index,follow', NULL),
(32, 'blog_post', 4, 'fr', 'Meilleures Pratiques de Conversion Web', 'Techniques UX, rédaction et design pour augmenter les prospects et la confiance client.', 'blog digital, meilleures pratiques de conversion web, cameroun', 'Meilleures Pratiques de Conversion Web', 'Techniques UX, rédaction et design pour augmenter les prospects et la confiance client.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog/website-conversion-best-practices', 'index,follow', NULL),
(33, 'blog_post', 5, 'en', 'Social Media Strategies for Local Business Growth', 'Practical tips to use social platforms as a sales and brand engine.', 'digital blog, social media strategies for local business growth, cameroon', 'Social Media Strategies for Local Business Growth', 'Practical tips to use social platforms as a sales and brand engine.', NULL, 'http://localhost/dbdigitalagency/public/en/blog/social-media-strategies-for-local-business-growth', 'index,follow', NULL),
(34, 'blog_post', 5, 'fr', 'Stratégies Social Media pour la Croissance des Entreprises Locales', 'Conseils pratiques pour utiliser les réseaux sociaux comme levier de vente et de notoriété.', 'blog digital, stratégies social media pour la croissance des entreprises locales, cameroun', 'Stratégies Social Media pour la Croissance des Entreprises Locales', 'Conseils pratiques pour utiliser les réseaux sociaux comme levier de vente et de notoriété.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog/social-media-strategies-for-local-business-growth', 'index,follow', NULL),
(35, 'blog_post', 6, 'en', 'Data-Driven Decisions for Growing Companies', 'How business analytics help prioritize digital investments and optimize campaigns.', 'digital blog, data-driven decisions for growing companies, cameroon', 'Data-Driven Decisions for Growing Companies', 'How business analytics help prioritize digital investments and optimize campaigns.', NULL, 'http://localhost/dbdigitalagency/public/en/blog/data-driven-decisions-for-growing-companies', 'index,follow', NULL),
(36, 'blog_post', 6, 'fr', 'Décisions Basées sur les Données pour les Entreprises en Croissance', 'Comment l’analytique d’entreprise aide à prioriser les investissements digitaux et optimiser les campagnes.', 'blog digital, décisions basées sur les données pour les entreprises en croissance, cameroun', 'Décisions Basées sur les Données pour les Entreprises en Croissance', 'Comment l’analytique d’entreprise aide à prioriser les investissements digitaux et optimiser les campagnes.', NULL, 'http://localhost/dbdigitalagency/public/fr/blog/data-driven-decisions-for-growing-companies', 'index,follow', NULL),
(37, 'office', 1, 'fr', 'Agence digitale à Douala', 'DB Digital Agency accompagne les entreprises à Douala : stratégie digitale, web, branding, SEO et acquisition.', 'agence digitale douala, seo local, web cameroun', 'Agence digitale à Douala', 'DB Digital Agency accompagne les entreprises à Douala : stratégie digitale, web, branding, SEO et acquisition.', NULL, 'http://localhost/dbdigitalagency/public/fr/agence-digitale/douala', 'index,follow', NULL),
(38, 'office', 1, 'en', 'Digital agency in Douala', 'DB Digital Agency supports businesses in Douala with digital strategy, web, branding, SEO and acquisition.', 'digital agency douala, local seo, web cameroon', 'Digital agency in Douala', 'DB Digital Agency supports businesses in Douala with digital strategy, web, branding, SEO and acquisition.', NULL, 'http://localhost/dbdigitalagency/public/en/digital-agency/douala', 'index,follow', NULL),
(39, 'office', 2, 'fr', 'Agence digitale à Yaoundé', 'DB Digital Agency accompagne les entreprises à Yaoundé : stratégie digitale, web, branding, SEO et acquisition.', 'agence digitale yaoundé, seo local, web cameroun', 'Agence digitale à Yaoundé', 'DB Digital Agency accompagne les entreprises à Yaoundé : stratégie digitale, web, branding, SEO et acquisition.', NULL, 'http://localhost/dbdigitalagency/public/fr/agence-digitale/yaounde', 'index,follow', NULL),
(40, 'office', 2, 'en', 'Digital agency in Yaoundé', 'DB Digital Agency supports businesses in Yaoundé with digital strategy, web, branding, SEO and acquisition.', 'digital agency yaoundé, local seo, web cameroon', 'Digital agency in Yaoundé', 'DB Digital Agency supports businesses in Yaoundé with digital strategy, web, branding, SEO and acquisition.', NULL, 'http://localhost/dbdigitalagency/public/en/digital-agency/yaounde', 'index,follow', NULL),
(41, 'office', 3, 'fr', 'Agence digitale à Bafoussam', 'DB Digital Agency accompagne les entreprises à Bafoussam : stratégie digitale, web, branding, SEO et acquisition.', 'agence digitale bafoussam, seo local, web cameroun', 'Agence digitale à Bafoussam', 'DB Digital Agency accompagne les entreprises à Bafoussam : stratégie digitale, web, branding, SEO et acquisition.', NULL, 'http://localhost/dbdigitalagency/public/fr/agence-digitale/bafoussam', 'index,follow', NULL),
(42, 'office', 3, 'en', 'Digital agency in Bafoussam', 'DB Digital Agency supports businesses in Bafoussam with digital strategy, web, branding, SEO and acquisition.', 'digital agency bafoussam, local seo, web cameroon', 'Digital agency in Bafoussam', 'DB Digital Agency supports businesses in Bafoussam with digital strategy, web, branding, SEO and acquisition.', NULL, 'http://localhost/dbdigitalagency/public/en/digital-agency/bafoussam', 'index,follow', NULL),
(43, 'page', 4, 'en', 'Legal notice', 'Legal information about the publication and use of dbdigitalagency.com.', 'legal notice, privacy, gdpr, cameroon', 'Legal notice', 'Legal information about the publication and use of dbdigitalagency.com.', NULL, 'http://localhost/dbdigitalagency/public/en/legal-notice', 'index,follow', NULL),
(44, 'page', 4, 'fr', 'Mentions légales', 'Informations légales relatives à l\'édition et à l\'utilisation du site dbdigitalagency.com.', 'mentions légales, confidentialité, rgpd, cameroun', 'Mentions légales', 'Informations légales relatives à l\'édition et à l\'utilisation du site dbdigitalagency.com.', NULL, 'http://localhost/dbdigitalagency/public/fr/mentions-legales', 'index,follow', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seo_redirects`
--

CREATE TABLE `seo_redirects` (
  `id` int UNSIGNED NOT NULL,
  `from_path` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `to_path` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `status_code` smallint NOT NULL DEFAULT '301',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seo_redirects`
--

INSERT INTO `seo_redirects` (`id`, `from_path`, `to_path`, `status_code`, `is_active`, `created_at`) VALUES
(1, '/index.php', '/fr', 301, 1, '2026-06-08 15:19:41'),
(2, '/about.php', '/fr/about', 301, 1, '2026-06-08 15:19:41'),
(3, '/services.php', '/fr/services', 301, 1, '2026-06-08 15:19:41'),
(4, '/services-details.php', '/fr/services', 301, 1, '2026-06-08 15:19:41'),
(5, '/projects.php', '/fr/projects', 301, 1, '2026-06-08 15:19:41'),
(6, '/blog.php', '/fr/blog', 301, 1, '2026-06-08 15:19:41'),
(7, '/contact.php', '/fr/contact', 301, 1, '2026-06-08 15:19:41'),
(8, '/get-quote.php', '/fr/devis', 301, 1, '2026-06-08 15:19:41'),
(9, '/sitemap.php', '/sitemap.xml', 301, 1, '2026-06-08 15:19:41'),
(10, '/process-contact.php', '/fr/contact', 301, 1, '2026-06-08 15:19:41'),
(11, '/process-quote.php', '/fr/devis', 301, 1, '2026-06-08 15:19:41'),
(12, '/process-newsletter.php', '/fr', 301, 1, '2026-06-08 15:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `seo_sitemap_config`
--

CREATE TABLE `seo_sitemap_config` (
  `id` int UNSIGNED NOT NULL,
  `entity_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `changefreq` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'weekly',
  `priority` decimal(2,1) NOT NULL DEFAULT '0.5',
  `is_included` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seo_sitemap_config`
--

INSERT INTO `seo_sitemap_config` (`id`, `entity_type`, `changefreq`, `priority`, `is_included`) VALUES
(1, 'home', 'weekly', 1.0, 1),
(2, 'page', 'monthly', 0.8, 1),
(3, 'service', 'monthly', 0.9, 1),
(4, 'project', 'monthly', 0.7, 1),
(5, 'blog', 'weekly', 0.7, 1),
(6, 'quote', 'monthly', 0.6, 1),
(7, 'contact', 'monthly', 0.8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `detail_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quote_icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quote_color` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quote_bg` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `slug`, `icon`, `image`, `detail_image`, `quote_icon`, `quote_color`, `quote_bg`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'digital-strategy', 'flaticon-mission', 'h4_services_img01.jpg', 'services_details01.jpg', 'fa-bullseye', '#534AB7', 'rgba(83,74,183,0.1)', 1, 1, NULL, '2026-06-10 08:14:11'),
(2, 'web-development', 'flaticon-code', 'h4_services_img02.jpg', 'services_details02.jpg', 'fa-code', '#185FA5', 'rgba(56,135,221,0.1)', 2, 1, NULL, NULL),
(3, 'branding', 'flaticon-design', 'h4_services_img03.jpg', 'services_details03.jpg', 'fa-palette', '#534AB7', 'rgba(83,74,183,0.1)', 3, 1, NULL, NULL),
(4, 'marketing', 'flaticon-profit', 'h4_services_img04.jpg', 'services_details04.jpg', 'fa-chart-line', '#1D9E75', 'rgba(29,158,117,0.1)', 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_faqs`
--

CREATE TABLE `service_faqs` (
  `id` int UNSIGNED NOT NULL,
  `service_id` int UNSIGNED NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_faqs`
--

INSERT INTO `service_faqs` (`id`, `service_id`, `sort_order`) VALUES
(64, 2, 1),
(65, 2, 2),
(66, 2, 3),
(67, 3, 1),
(68, 3, 2),
(69, 3, 3),
(70, 4, 1),
(71, 4, 2),
(72, 4, 3),
(76, 1, 1),
(77, 1, 2),
(78, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `service_translations`
--

CREATE TABLE `service_translations` (
  `id` int UNSIGNED NOT NULL,
  `service_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `intro` text COLLATE utf8mb4_general_ci,
  `body` longtext COLLATE utf8mb4_general_ci,
  `highlight_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `highlight_text` text COLLATE utf8mb4_general_ci,
  `goal_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `goal_text` text COLLATE utf8mb4_general_ci,
  `challenge_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `challenge_text` text COLLATE utf8mb4_general_ci,
  `benefits` json DEFAULT NULL,
  `quote_title_key` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quote_sub_key` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_translations`
--

INSERT INTO `service_translations` (`id`, `service_id`, `locale`, `title`, `description`, `intro`, `body`, `highlight_title`, `highlight_text`, `goal_title`, `goal_text`, `challenge_title`, `challenge_text`, `benefits`, `quote_title_key`, `quote_sub_key`) VALUES
(1, 1, 'fr', 'Stratégie Digitale', 'Positionnement, message, parcours client et plan d’exécution clair pour atteindre vos objectifs.', 'Nous aidons les marques ambitieuses à définir où se positionner, comment gagner et quoi construire en priorité. De l’analyse de marché à la priorisation des canaux, nous transformons vos objectifs business en feuille de route digitale concrète, adaptée au contexte camerounais et africain.', 'Que vous lanciez une nouvelle offre ou repositionniez une marque existante, nos stratèges travaillent avec votre direction pour aligner message, segments d’audience et priorités d’acquisition — afin que chaque investissement produise un impact mesurable.', 'Décisions guidées par la data', 'Nous combinons étude de marché, benchmark concurrentiel et analytique pour prioriser les initiatives au meilleur ROI. Pas de suppositions — des hypothèses claires, des KPI mesurables et une optimisation continue.', 'Notre objectif', 'Vous offrir une vision claire de votre croissance digitale : un plan priorisé que votre équipe peut exécuter avec confiance, trimestre après trimestre.', 'Défis que nous résolvons', 'Présence digitale fragmentée, positionnement flou et campagnes qui ne convertissent pas : nous traitons ces blocages de front.', '[\"Audit digital complet & veille concurrentielle\", \"Feuille de route priorisée sur 90 jours\", \"KPIs de croissance & cadre de reporting\"]', NULL, NULL),
(2, 1, 'en', 'Digital Strategy', 'Positioning, messaging, customer journey and a clear execution plan to hit growth targets.', 'We help ambitious brands define where to play, how to win and what to build first. From market analysis to channel prioritization, we turn business goals into a concrete digital roadmap tailored to the Cameroonian and African context.', 'Whether you are launching a new offer or repositioning an existing brand, our strategists work alongside your leadership team to align messaging, audience segments and acquisition priorities — so every euro invested moves the needle.', 'Data-Driven Decisions', 'We combine market research, competitor benchmarks and analytics to prioritize initiatives with the highest ROI. No guesswork — just clear hypotheses, measurable KPIs and iterative optimization.', 'Our Goal', 'Give you a single source of truth for your digital growth: a prioritized plan your team can execute with confidence, quarter after quarter.', 'Challenges We Solve', 'Fragmented digital presence, unclear positioning and campaigns that do not convert are common blockers we address head-on.', '[\"Full digital audit & competitive scan\", \"Prioritized 90-day action roadmap\", \"Growth KPIs & reporting framework\"]', NULL, NULL),
(3, 2, 'fr', 'Développement Web', 'Sites et applications web rapides et sécurisés, pensés performance, SEO et conversion.', 'Nous concevons des sites et applications web rapides, bien référencés et orientés conversion. Du site vitrine à la plateforme sur mesure, notre stack est choisie pour la fiabilité, la sécurité et la maintenabilité dans le temps.', 'Mobile-first par défaut, nos projets intègrent analytique, fondations SEO et suivi de conversion dès le jour 1 — pour mesurer l’impact dès le lancement.', 'Performance & SEO intégrés', 'Core Web Vitals, balisage sémantique, données structurées et architecture propre ne sont pas des options — ils font partie de chaque livraison. Votre site est prêt à performer en recherche locale et internationale.', 'Notre objectif', 'Livrer un produit digital dont votre équipe est fière et que vos clients aiment utiliser — capable de grandir avec votre activité sans refonte coûteuse.', 'Défis que nous résolvons', 'Temps de chargement lents, mauvaise expérience mobile et sites difficiles à mettre à jour : nous les éliminons avec un code moderne et maintenable.', '[\"Performance optimisée & Core Web Vitals\", \"Sécurisation & maintenance continue\", \"SEO technique & intégration analytique\"]', NULL, NULL),
(4, 2, 'en', 'Web Development', 'Fast, secure websites and web apps built for performance, SEO and conversion.', 'We build websites and web applications that load fast, rank well and convert visitors into leads. From corporate sites to custom platforms, our stack is chosen for reliability, security and long-term maintainability.', 'Mobile-first by default, our projects integrate analytics, SEO foundations and conversion tracking from day one — so you can measure impact as soon as you launch.', 'Performance & SEO Built In', 'Core Web Vitals, semantic markup, structured data and clean architecture are not add-ons — they are part of every build. Your site is ready to compete in local and international search.', 'Our Goal', 'Deliver a digital product your team is proud of and your customers love to use — one that scales with your business without costly rebuilds.', 'Challenges We Solve', 'Slow load times, poor mobile experience and sites that are impossible to update are problems we eliminate with modern, maintainable code.', '[\"Optimized performance & Core Web Vitals\", \"Security hardening & ongoing maintenance\", \"Technical SEO & analytics integration\"]', NULL, NULL),
(5, 3, 'fr', 'Branding & UI/UX', 'Identité de marque et design produit pour renforcer la confiance et déclencher l’action.', 'Les marques fortes reposent sur la clarté, la cohérence et l’émotion. Nous créons des identités visuelles et des expériences utilisateur qui communiquent votre valeur immédiatement et orientent vers l’action.', 'Du système logo et de la charte graphique aux wireframes et UI haute fidélité, nous garantissons que chaque point de contact — site, réseaux, pitch deck — raconte la même histoire convaincante.', 'Un design qui convertit', 'Nous combinons stratégie de marque et bonnes pratiques UX : hiérarchie claire, typographie accessible, mises en page testées et CTA placés là où l’utilisateur regarde naturellement.', 'Notre objectif', 'Rendre votre marque immédiatement reconnaissable et rassurante — en ligne comme hors ligne — pour que vos prospects vous choisissent avant même de lire votre offre.', 'Défis que nous résolvons', 'Des visuels incohérents, une identité dépassée et des interfaces qui perdent l’utilisateur vous coûtent crédibilité et ventes chaque jour.', '[\"Identité visuelle cohérente & charte graphique\", \"Recherche UX & interfaces testées\", \"Assets prêts pour le web et l’impression\"]', NULL, NULL),
(6, 3, 'en', 'Branding & UI/UX', 'Brand identity and product design that build trust and make people take action.', 'Strong brands are built on clarity, consistency and emotion. We craft visual identities and user experiences that communicate your value instantly and guide users toward action.', 'From logo systems and brand guidelines to wireframes and high-fidelity UI, we ensure every touchpoint — website, social, pitch deck — tells the same compelling story.', 'Design That Converts', 'We combine brand strategy with UX best practices: clear hierarchy, accessible typography, tested layouts and CTAs placed where users naturally look.', 'Our Goal', 'Make your brand instantly recognizable and trustworthy — online and offline — so prospects choose you before they even read your offer.', 'Challenges We Solve', 'Inconsistent visuals, outdated identity and interfaces that confuse users cost you credibility and sales every day.', '[\"Cohesive visual identity & brand guidelines\", \"UX research & tested interface design\", \"Design assets ready for web & print\"]', NULL, NULL),
(7, 4, 'fr', 'Marketing d’Acquisition', 'SEO, publicité et contenus qui génèrent des prospects qualifiés de façon régulière.', 'Du trafic sans conversion, c’est du budget gaspillé. Nous construisons des systèmes d’acquisition — SEO, publicité, email et contenu — qui attirent la bonne audience et transforment l’intérêt en prospects qualifiés.', 'Fondées sur l’analytique et les tests continus, nos campagnes sont optimisées pour le ROI — avec un reporting transparent pour savoir en permanence ce qui fonctionne.', 'Croissance mesurable', 'Nous mettons en place tracking, attribution et tableaux de bord dès le départ. Chaque campagne est liée à des résultats business : leads, ventes, coût d’acquisition et valeur vie client.', 'Notre objectif', 'Construire un flux prévisible de prospects qualifiés pour que vos commerciaux passent leur temps à conclure — pas à courir après des contacts froids.', 'Défis que nous résolvons', 'Budget pub sans suivi, faible visibilité SEO locale et contenus qui ne se positionnent pas : nous corrigeons ces freins avec des campagnes structurées et orientées tests.', '[\"Campagnes trackées avec reporting ROI clair\", \"SEO local Cameroun & Afrique de l’Ouest\", \"Contenus qui se positionnent et convertissent\"]', NULL, NULL),
(8, 4, 'en', 'Growth Marketing', 'SEO, paid media and content systems that consistently generate qualified leads.', 'Traffic without conversion is wasted budget. We build acquisition systems — SEO, paid ads, email and content — that attract the right audience and turn interest into qualified leads.', 'Grounded in analytics and continuous testing, our campaigns are optimized for ROI — with transparent reporting so you always know what is working.', 'Measurable Growth', 'We set up tracking, attribution and dashboards from the start. Every campaign is tied to business outcomes: leads, sales, cost per acquisition and lifetime value.', 'Our Goal', 'Build a predictable pipeline of qualified prospects so your sales team spends time closing — not chasing cold leads.', 'Challenges We Solve', 'Ad spend with no tracking, poor local SEO visibility and content that does not rank are growth killers we fix with structured, test-driven campaigns.', '[\"Tracked campaigns with clear ROI reporting\", \"Local SEO for Cameroon & West Africa\", \"Content that ranks and converts\"]', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `type` varchar(31) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `context` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_branding`
--

CREATE TABLE `site_branding` (
  `id` int UNSIGNED NOT NULL,
  `logo_light_id` int UNSIGNED DEFAULT NULL,
  `logo_dark_id` int UNSIGNED DEFAULT NULL,
  `logo_mobile_id` int UNSIGNED DEFAULT NULL,
  `favicon_id` int UNSIGNED DEFAULT NULL,
  `apple_touch_icon_id` int UNSIGNED DEFAULT NULL,
  `og_default_image_id` int UNSIGNED DEFAULT NULL,
  `admin_logo_id` int UNSIGNED DEFAULT NULL,
  `admin_favicon_id` int UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_branding`
--

INSERT INTO `site_branding` (`id`, `logo_light_id`, `logo_dark_id`, `logo_mobile_id`, `favicon_id`, `apple_touch_icon_id`, `og_default_image_id`, `admin_logo_id`, `admin_favicon_id`, `updated_at`) VALUES
(2, 154, 152, 153, 151, 151, 207, NULL, NULL, '2026-06-09 14:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int UNSIGNED NOT NULL,
  `setting_key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_general_ci,
  `setting_group` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'general',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'DB Digital Agency', 'general', NULL, NULL),
(2, 'site_url', 'http://localhost/dbdigitalagency/public', 'general', NULL, NULL),
(3, 'contact_address', 'Douala, Yaounde, Bafoussam, Cameroon', 'contact', NULL, NULL),
(4, 'contact_phone_1', '+237 691 323 249', 'contact', NULL, NULL),
(5, 'contact_phone_2', '+237 658 910 343', 'contact', NULL, NULL),
(6, 'contact_phone_3', '+237 640 819 846', 'contact', NULL, NULL),
(7, 'contact_email', 'contact@dbdigitalagency.com', 'contact', NULL, NULL),
(8, 'whatsapp_number', '237691323249', 'contact', NULL, NULL),
(9, 'admin_email', 'contact@dbdigitalagency.com', 'email', NULL, NULL),
(10, 'smtp_host', 'smtp.gmail.com', 'email', NULL, NULL),
(11, 'smtp_port', '587', 'email', NULL, NULL),
(12, 'smtp_username', '', 'email', NULL, NULL),
(13, 'smtp_encryption', 'tls', 'email', NULL, NULL),
(14, 'smtp_from_email', 'sales@dbdigitalagency.com', 'email', NULL, NULL),
(15, 'smtp_from_name', 'DB Digital Agency', 'email', NULL, NULL),
(16, 'seo_index', '', 'seo', NULL, NULL),
(17, 'contact_phone', '+237 691 323 249', 'contact', NULL, NULL),
(18, 'facebook_url', 'https://www.facebook.com/share/18a3vkULiE', 'social', NULL, NULL),
(19, 'linkedin_url', 'https://www.linkedin.com/company/db-digitalagency-com', 'social', NULL, NULL),
(20, 'youtube_url', 'https://www.youtube.com/@DBdigitalagency', 'social', NULL, NULL),
(21, 'tiktok_url', 'https://www.tiktok.com/@db.digital.agency5', 'social', NULL, NULL),
(22, 'blog_tags', '[{\"en\":\"SEO\",\"fr\":\"SEO\"},{\"en\":\"Conversion\",\"fr\":\"Conversion\"},{\"en\":\"UI\\/UX\",\"fr\":\"UI\\/UX\"},{\"en\":\"Ads\",\"fr\":\"Ads\"},{\"en\":\"Content\",\"fr\":\"Contenu\"}]', 'content', NULL, NULL),
(23, 'social_facebook', 'https://www.facebook.com/share/18a3vkULiE', 'social', NULL, NULL),
(24, 'social_tiktok', 'https://www.tiktok.com/@db.digital.agency5', 'social', NULL, NULL),
(25, 'social_youtube', 'https://www.youtube.com/@DBdigitalagency', 'social', NULL, NULL),
(26, 'social_linkedin', 'https://www.linkedin.com/company/db-digitalagency-com', 'social', NULL, NULL),
(27, 'tracking_enabled', '1', 'integrations', NULL, NULL),
(28, 'cookie_banner_enabled', '1', 'integrations', NULL, NULL),
(29, 'recaptcha_enabled', '0', 'integrations', NULL, NULL),
(30, 'form_rate_limit_max', '8', 'integrations', NULL, NULL),
(31, 'form_rate_limit_minutes', '15', 'integrations', NULL, NULL),
(32, 'defer_scripts', '1', 'integrations', NULL, NULL),
(33, 'lazy_images', '1', 'integrations', NULL, NULL),
(34, 'preload_fonts', '1', 'integrations', NULL, NULL),
(35, 'privacy_page_slug_fr', 'politique-confidentialite', 'integrations', NULL, NULL),
(36, 'privacy_page_slug_en', 'privacy-policy', 'integrations', NULL, NULL),
(37, 'legal_page_slug_fr', 'mentions-legales', 'integrations', NULL, NULL),
(38, 'legal_page_slug_en', 'legal-notice', 'integrations', NULL, NULL),
(39, 'sitemap_enabled', '1', 'seo', NULL, NULL),
(40, 'sitemap_changefreq', 'weekly', 'seo', NULL, NULL),
(41, 'sitemap_priority', '0.8', 'seo', NULL, NULL),
(42, 'tinymce_api_key', '', 'integrations', NULL, NULL),
(43, 'assets_minified', '0', 'integrations', NULL, NULL),
(44, 'recaptcha_secret_key', '', 'integrations', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `image`, `sort_order`, `is_active`) VALUES
(1, 'team_img_rose.png', 1, 1),
(2, 'team_img_pascal.png', 2, 0),
(3, 'team_img_stephane.png', 3, 1),
(4, 'team_img_fabien.png', 4, 1),
(5, 'team_img_delphine.png', 5, 1),
(6, 'team_img_lionel.png', 6, 1),
(7, 'team_img_van.png', 7, 1),
(8, 'team_img_ulrich.png', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `team_member_translations`
--

CREATE TABLE `team_member_translations` (
  `id` int UNSIGNED NOT NULL,
  `team_member_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_member_translations`
--

INSERT INTO `team_member_translations` (`id`, `team_member_id`, `locale`, `name`, `role`, `bio`) VALUES
(1, 1, 'fr', 'Eugénie Rose Yuoyang', 'PDG, DB Digital Agency', NULL),
(2, 1, 'en', 'Eugénie Rose Yuoyang', 'CEO, DB Digital Agency', NULL),
(3, 2, 'fr', 'Pierre Pascal Essomba', 'Designer Graphique', ''),
(4, 2, 'en', 'Pierre Pascal Essomba', 'Graphic Designer', ''),
(5, 3, 'fr', 'Stephane Kamga', 'Développeur Web & Mobile', NULL),
(6, 3, 'en', 'Stephane Kamga', 'Web & Mobile Developer', NULL),
(7, 4, 'fr', 'Fabien Meboue', 'DG, DB Digital Agency Douala', NULL),
(8, 4, 'en', 'Fabien Meboue', 'DG, DB Digital Agency Douala', NULL),
(9, 5, 'fr', 'Delphine Mengue', 'Vidéaste Graphiste', NULL),
(10, 5, 'en', 'Delphine Mengue', 'Video Designer', NULL),
(11, 6, 'fr', 'Lionel Dounia', 'Directeur Marketing', NULL),
(12, 6, 'en', 'Lionel Dounia', 'Marketing Director', NULL),
(13, 7, 'fr', 'Van Besong', 'Community Manager', NULL),
(14, 7, 'en', 'Van Besong', 'Community Manager', NULL),
(15, 8, 'fr', 'Ulrich Fotso', 'Développeur Web & Mobile', NULL),
(16, 8, 'en', 'Ulrich Fotso', 'Web & Mobile Developer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `image`, `rating`, `sort_order`, `is_active`) VALUES
(1, 'temoignage_kamga.png', 5, 1, 1),
(2, 'temoignage_kamagate.png', 5, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_translations`
--

CREATE TABLE `testimonial_translations` (
  `id` int UNSIGNED NOT NULL,
  `testimonial_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `quote` text COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonial_translations`
--

INSERT INTO `testimonial_translations` (`id`, `testimonial_id`, `locale`, `quote`, `author`, `role`) VALUES
(1, 1, 'fr', 'Avant DB Digital Agency, nous avions peu d’inscriptions. En quelques semaines, leur stratégie a boosté notre visibilité et attiré des candidats qualifiés. Nous recommandons vivement.', 'Mr. Aristide KAMGA', 'Direction Générale, N2VTI'),
(2, 1, 'en', 'Before working with DB Digital Agency, we had few enrollments. Within weeks, their strategy boosted our visibility and attracted qualified applicants. We highly recommend them.', 'Mr. Aristide KAMGA', 'General Direction, N2VTI'),
(3, 2, 'fr', 'Nous cherchions une solution d’inscriptions prévisible. DB Digital Agency nous a apporté une stratégie efficace, générant plus de prospects qualifiés et de conversions. Un partenaire clé de notre croissance.', 'ALLY Kamagaté', 'Administration, DM Academy Côte d’Ivoire'),
(4, 2, 'en', 'We were looking for a predictable enrollment solution. DB Digital Agency delivered an effective strategy that increased qualified leads and conversions. A key partner in our growth.', 'ALLY Kamagaté', 'Administration, DM Academy Ivory Coast');

-- --------------------------------------------------------

--
-- Table structure for table `translation_keys`
--

CREATE TABLE `translation_keys` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'general',
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translation_keys`
--

INSERT INTO `translation_keys` (`id`, `key`, `group`, `description`) VALUES
(1, 'meta_suffix', 'seo', NULL),
(2, 'meta_default_description', 'seo', NULL),
(3, 'nav_home', 'navigation', NULL),
(4, 'nav_about', 'navigation', NULL),
(5, 'nav_services', 'navigation', NULL),
(6, 'nav_projects', 'navigation', NULL),
(7, 'nav_blog', 'navigation', NULL),
(8, 'nav_contact', 'navigation', NULL),
(9, 'btn_quote', 'buttons', NULL),
(10, 'btn_read_more', 'buttons', NULL),
(11, 'btn_see_all', 'buttons', NULL),
(12, 'btn_contact', 'buttons', NULL),
(13, 'hero_title', 'app', NULL),
(14, 'hero_desc', 'app', NULL),
(15, 'features_growing', 'app', NULL),
(16, 'features_finance', 'app', NULL),
(17, 'features_tax', 'app', NULL),
(18, 'about_subtitle', 'app', NULL),
(19, 'about_page_subtitle', 'app', NULL),
(20, 'about_title', 'app', NULL),
(21, 'about_page_title', 'app', NULL),
(22, 'about_page_desc', 'app', NULL),
(23, 'about_ceo', 'app', NULL),
(24, 'about_dg_douala', 'app', NULL),
(25, 'about_dg_baf', 'app', NULL),
(26, 'services_subtitle', 'app', NULL),
(27, 'services_title', 'app', NULL),
(28, 'services_btn', 'app', NULL),
(29, 'homepage_services_lead', 'app', NULL),
(30, 'services_page_title', 'app', NULL),
(31, 'services_page_lead', 'app', NULL),
(32, 'services_block_subtitle', 'app', NULL),
(33, 'services_block_title', 'app', NULL),
(34, 'services_block_cta', 'app', NULL),
(35, 'services_details_cta', 'app', NULL),
(36, 'services_see_details', 'app', NULL),
(37, 'services_details_sidebar_help', 'app', NULL),
(38, 'services_details_sidebar_quote', 'app', NULL),
(39, 'services_details_sidebar_quote_lead', 'app', NULL),
(40, 'services_details_faq_title', 'app', NULL),
(41, 'services_details_all_services', 'app', NULL),
(42, 'services_details_back', 'app', NULL),
(43, 'services_details_benefits', 'app', NULL),
(44, 'counter_projects', 'app', NULL),
(45, 'counter_clients', 'app', NULL),
(46, 'counter_awards', 'app', NULL),
(47, 'counter_countries', 'app', NULL),
(48, 'call_for_more_info', 'app', NULL),
(49, 'call_desc', 'app', NULL),
(50, 'projects_subtitle', 'app', NULL),
(51, 'projects_title', 'app', NULL),
(52, 'projects_btn', 'app', NULL),
(53, 'team_subtitle', 'app', NULL),
(54, 'team_title', 'app', NULL),
(55, 'team_lead', 'app', NULL),
(56, 'team_role_strategy', 'app', NULL),
(57, 'team_role_graphic_designer', 'app', NULL),
(58, 'team_role_dev', 'app', NULL),
(59, 'team_role_community_manager', 'app', NULL),
(60, 'team_role_video_designer', 'app', NULL),
(61, 'team_role_marketing_director', 'app', NULL),
(62, 'testimonial_title', 'app', NULL),
(63, 'blog_subtitle', 'app', NULL),
(64, 'blog_title', 'app', NULL),
(65, 'blog_page_title', 'app', NULL),
(66, 'blog_page_description', 'app', NULL),
(67, 'blog_no_posts', 'app', NULL),
(68, 'blog_sidebar_categories', 'app', NULL),
(69, 'blog_sidebar_recent', 'app', NULL),
(70, 'blog_sidebar_tags', 'app', NULL),
(71, 'contact_sales_title', 'contact', NULL),
(72, 'contact_sales_desc', 'contact', NULL),
(73, 'contact_general_title', 'contact', NULL),
(74, 'contact_general_desc', 'contact', NULL),
(75, 'contact_support_title', 'contact', NULL),
(76, 'contact_support_desc', 'contact', NULL),
(77, 'contact_page_eyebrow', 'contact', NULL),
(78, 'contact_page_title', 'contact', NULL),
(79, 'contact_page_lead', 'contact', NULL),
(80, 'contact_form_eyebrow', 'contact', NULL),
(81, 'contact_form_title', 'contact', NULL),
(82, 'contact_form_subtitle', 'contact', NULL),
(83, 'contact_form_name_label', 'contact', NULL),
(84, 'contact_form_phone_label', 'contact', NULL),
(85, 'contact_form_email_label', 'contact', NULL),
(86, 'contact_form_message_label', 'contact', NULL),
(87, 'contact_form_name_placeholder', 'contact', NULL),
(88, 'contact_form_phone_placeholder', 'contact', NULL),
(89, 'contact_form_email_placeholder', 'contact', NULL),
(90, 'contact_form_message_placeholder', 'contact', NULL),
(91, 'contact_form_submit', 'contact', NULL),
(92, 'contact_form_trust_response', 'contact', NULL),
(93, 'contact_success', 'contact', NULL),
(94, 'contact_success_db_only', 'contact', NULL),
(95, 'contact_error_db', 'contact', NULL),
(96, 'newsletter_success', 'app', NULL),
(97, 'newsletter_already_subscribed', 'app', NULL),
(98, 'newsletter_reactivated', 'app', NULL),
(99, 'newsletter_error_email', 'app', NULL),
(100, 'newsletter_error_db', 'app', NULL),
(101, 'footer_newsletter', 'footer', NULL),
(102, 'footer_newsletter_desc', 'footer', NULL),
(103, 'footer_email_placeholder', 'footer', NULL),
(104, 'footer_subscribe', 'footer', NULL),
(105, 'footer_no_spam', 'footer', NULL),
(106, 'footer_copyright', 'footer', NULL),
(107, 'footer_info_title', 'footer', NULL),
(108, 'footer_menu_title', 'footer', NULL),
(109, 'footer_opening_hours', 'footer', NULL),
(110, 'footer_sunday', 'footer', NULL),
(111, 'footer_closed', 'footer', NULL),
(112, 'footer_menu_company', 'footer', NULL),
(113, 'footer_menu_careers', 'footer', NULL),
(114, 'footer_menu_press', 'footer', NULL),
(115, 'footer_menu_privacy', 'footer', NULL),
(116, 'footer_quicklinks_title', 'footer', NULL),
(117, 'footer_ql_how', 'footer', NULL),
(118, 'footer_ql_partners', 'footer', NULL),
(119, 'footer_ql_testimonials', 'footer', NULL),
(120, 'footer_ql_cases', 'footer', NULL),
(121, 'footer_ql_pricing', 'footer', NULL),
(122, 'whatsapp_text', 'app', NULL),
(123, 'quote_title', 'quote', NULL),
(124, 'quote_subtitle', 'quote', NULL),
(125, 'quote_desc', 'quote', NULL),
(126, 'quote_quick_response', 'quote', NULL),
(127, 'quote_secure_approach', 'quote', NULL),
(128, 'quote_talk_to_us', 'quote', NULL),
(129, 'quote_step_service', 'quote', NULL),
(130, 'quote_step_project', 'quote', NULL),
(131, 'quote_step_contact', 'quote', NULL),
(132, 'quote_step_review', 'quote', NULL),
(133, 'quote_service_label', 'quote', NULL),
(134, 'quote_subject_label', 'quote', NULL),
(135, 'quote_type_label', 'quote', NULL),
(136, 'quote_budget_label', 'quote', NULL),
(137, 'quote_start_label', 'quote', NULL),
(138, 'quote_message_label', 'quote', NULL),
(139, 'quote_brief_label', 'quote', NULL),
(140, 'quote_file_hint', 'quote', NULL),
(141, 'quote_file_max_label', 'quote', NULL),
(142, 'quote_validation_file_size', 'quote', NULL),
(143, 'quote_fullname_label', 'quote', NULL),
(144, 'quote_company_label', 'quote', NULL),
(145, 'quote_email_label', 'quote', NULL),
(146, 'quote_whatsapp_label', 'quote', NULL),
(147, 'quote_review_title', 'quote', NULL),
(148, 'quote_ask_question', 'quote', NULL),
(149, 'quote_innovation_title', 'quote', NULL),
(150, 'quote_innovation_desc', 'quote', NULL),
(151, 'quote_step_of', 'quote', NULL),
(152, 'quote_step_of_total', 'quote', NULL),
(153, 'quote_continue', 'quote', NULL),
(154, 'quote_back', 'quote', NULL),
(155, 'quote_project_details_title', 'quote', NULL),
(156, 'quote_project_details_desc', 'quote', NULL),
(157, 'quote_contact_details_title', 'quote', NULL),
(158, 'quote_contact_details_desc', 'quote', NULL),
(159, 'quote_review_send_title', 'quote', NULL),
(160, 'quote_review_send_desc', 'quote', NULL),
(161, 'quote_select_service_desc', 'quote', NULL),
(162, 'quote_placeholder_subject', 'quote', NULL),
(163, 'quote_placeholder_message', 'quote', NULL),
(164, 'quote_placeholder_fullname', 'quote', NULL),
(165, 'quote_placeholder_company', 'quote', NULL),
(166, 'quote_placeholder_email', 'quote', NULL),
(167, 'quote_placeholder_whatsapp', 'quote', NULL),
(168, 'quote_file_none', 'quote', NULL),
(169, 'quote_validation_select_service', 'quote', NULL),
(170, 'quote_validation_required', 'quote', NULL),
(171, 'quote_validation_email', 'quote', NULL),
(172, 'quote_send_request', 'quote', NULL),
(173, 'quote_send_both_title', 'quote', NULL),
(174, 'quote_send_both_desc', 'quote', NULL),
(175, 'quote_svc_strategy_title', 'quote', NULL),
(176, 'quote_svc_strategy_sub', 'quote', NULL),
(177, 'quote_svc_web_title', 'quote', NULL),
(178, 'quote_svc_web_sub', 'quote', NULL),
(179, 'quote_svc_brand_title', 'quote', NULL),
(180, 'quote_svc_brand_sub', 'quote', NULL),
(181, 'quote_svc_marketing_title', 'quote', NULL),
(182, 'quote_svc_marketing_sub', 'quote', NULL),
(183, 'quote_type_new', 'quote', NULL),
(184, 'quote_type_redesign', 'quote', NULL),
(185, 'quote_type_maintenance', 'quote', NULL),
(186, 'quote_type_consulting', 'quote', NULL),
(187, 'quote_start_immediately', 'quote', NULL),
(188, 'quote_start_1_week', 'quote', NULL),
(189, 'quote_start_1_month', 'quote', NULL),
(190, 'quote_start_flexible', 'quote', NULL),
(191, 'quote_optional', 'quote', NULL),
(192, 'quote_option_email', 'quote', NULL),
(193, 'quote_option_whatsapp', 'quote', NULL),
(194, 'quote_send_method', 'quote', NULL),
(195, 'quote_success_email', 'quote', NULL),
(196, 'quote_success_whatsapp', 'quote', NULL),
(197, 'quote_error_db', 'quote', NULL),
(198, 'quote_error_email', 'quote', NULL),
(199, 'quote_whatsapp_intro', 'quote', NULL),
(200, 'quote_whatsapp_service', 'quote', NULL),
(201, 'quote_whatsapp_subject', 'quote', NULL),
(202, 'quote_whatsapp_type', 'quote', NULL),
(203, 'quote_whatsapp_budget', 'quote', NULL),
(204, 'quote_whatsapp_start', 'quote', NULL),
(205, 'quote_whatsapp_name', 'quote', NULL),
(206, 'quote_whatsapp_company', 'quote', NULL),
(207, 'quote_whatsapp_email', 'quote', NULL),
(208, 'quote_whatsapp_message', 'quote', NULL),
(209, 'quote_db_saved', 'quote', NULL),
(210, 'brand_title', 'app', NULL),
(211, 'brand_subtitle', 'app', NULL),
(212, 'locations_title', 'app', NULL),
(213, 'locations_eyebrow', 'app', NULL),
(214, 'locations_subtitle', 'app', NULL),
(215, 'locations_hint', 'app', NULL),
(216, 'locations_cta', 'app', NULL),
(217, 'locations_badge', 'app', NULL),
(218, 'locations_directions', 'app', NULL),
(219, 'breadcrumb_home', 'app', NULL),
(220, 'breadcrumb_about', 'app', NULL),
(221, 'breadcrumb_services', 'app', NULL),
(222, 'breadcrumb_projects', 'app', NULL),
(223, 'breadcrumb_blog', 'app', NULL),
(224, 'breadcrumb_contact', 'app', NULL),
(225, 'about_desc', 'app', NULL),
(226, 'homepage_exp_years', 'app', NULL),
(227, 'homepage_exp_label', 'app', NULL),
(228, 'homepage_about_lead', 'app', NULL),
(229, 'homepage_about_list_1', 'app', NULL),
(230, 'homepage_about_list_2', 'app', NULL),
(231, 'homepage_about_list_3', 'app', NULL),
(232, 'homepage_about_list_4', 'app', NULL),
(233, 'homepage_about_conclusion', 'app', NULL),
(234, 'about_expertise', 'app', NULL),
(235, 'about_expertise_title', 'app', NULL),
(236, 'about_expertise_subtitle', 'app', NULL),
(237, 'about_expertise_desc', 'app', NULL),
(238, 'about_skill_strategy', 'app', NULL),
(239, 'about_skill_brand', 'app', NULL),
(240, 'about_skill_growth', 'app', NULL),
(241, 'about_service_btn', 'app', NULL),
(242, 'about_company_type_1', 'app', NULL),
(243, 'about_company_type_2', 'app', NULL),
(244, 'about_company_type_3', 'app', NULL),
(245, 'services_page_subtitle', 'app', NULL),
(246, 'search_placeholder', 'app', NULL),
(247, 'search_title', 'app', NULL),
(248, 'prospect_portal_label', 'app', NULL),
(249, 'prospect_access_title', 'app', NULL),
(250, 'prospect_access_lead', 'app', NULL),
(251, 'prospect_invalid_link', 'app', NULL),
(252, 'prospect_expired_title', 'app', NULL),
(253, 'prospect_expired_lead', 'app', NULL),
(254, 'prospect_resend_heading', 'app', NULL),
(255, 'prospect_resend_lead', 'app', NULL),
(256, 'prospect_quote_id_label', 'app', NULL),
(257, 'prospect_email_label', 'app', NULL),
(258, 'prospect_resend_btn', 'app', NULL),
(259, 'prospect_resend_not_found', 'app', NULL),
(260, 'prospect_resend_failed', 'app', NULL),
(261, 'prospect_resend_success', 'app', NULL),
(262, 'prospect_back_access', 'app', NULL),
(263, 'prospect_dashboard_title', 'app', NULL),
(264, 'prospect_quote_ref', 'app', NULL),
(265, 'prospect_field_subject', 'app', NULL),
(266, 'prospect_field_service', 'app', NULL),
(267, 'prospect_field_budget', 'app', NULL),
(268, 'prospect_field_submitted', 'app', NULL),
(269, 'prospect_timeline_title', 'app', NULL),
(270, 'prospect_timeline_empty', 'app', NULL),
(271, 'prospect_documents_title', 'app', NULL),
(272, 'prospect_download_brief', 'app', NULL),
(273, 'prospect_no_brief', 'app', NULL),
(274, 'prospect_upload_label', 'app', NULL),
(275, 'prospect_upload_btn', 'app', NULL),
(276, 'prospect_upload_invalid', 'app', NULL),
(277, 'prospect_upload_too_large', 'app', NULL),
(278, 'prospect_upload_failed', 'app', NULL),
(279, 'prospect_upload_success', 'app', NULL),
(280, 'prospect_contact_title', 'app', NULL),
(281, 'prospect_whatsapp_btn', 'app', NULL),
(282, 'prospect_email_btn', 'app', NULL),
(283, 'prospect_session_expired', 'app', NULL),
(284, 'prospect_status_new', 'app', NULL),
(285, 'prospect_status_contacted', 'app', NULL),
(286, 'prospect_status_in_progress', 'app', NULL),
(287, 'prospect_status_completed', 'app', NULL),
(288, 'prospect_status_cancelled', 'app', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `translation_values`
--

CREATE TABLE `translation_values` (
  `id` int UNSIGNED NOT NULL,
  `key_id` int UNSIGNED NOT NULL,
  `locale` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translation_values`
--

INSERT INTO `translation_values` (`id`, `key_id`, `locale`, `value`) VALUES
(1, 1, 'fr', 'Agence Digitale'),
(2, 1, 'en', 'Digital Agency'),
(3, 2, 'fr', 'DB Digital Agency - Stratégie, design, développement web et marketing d’acquisition pour les entreprises ambitieuses au Cameroun.'),
(4, 2, 'en', 'DB Digital Agency - Strategy, design, web development and growth marketing for ambitious businesses in Cameroon.'),
(5, 3, 'fr', 'Accueil'),
(6, 3, 'en', 'Home'),
(7, 4, 'fr', 'À Propos'),
(8, 4, 'en', 'About Us'),
(9, 5, 'fr', 'Services'),
(10, 5, 'en', 'Services'),
(11, 6, 'fr', 'Projets'),
(12, 6, 'en', 'Projects'),
(13, 7, 'fr', 'Blog'),
(14, 7, 'en', 'Blog'),
(15, 8, 'fr', 'Contact'),
(16, 8, 'en', 'Contact'),
(17, 9, 'fr', 'Obtenir un Devis'),
(18, 9, 'en', 'Get A Quote'),
(19, 10, 'fr', 'En Savoir Plus'),
(20, 10, 'en', 'Read More'),
(21, 11, 'fr', 'Voir Tout'),
(22, 11, 'en', 'See All'),
(23, 12, 'fr', 'Nous Contacter'),
(24, 12, 'en', 'Contact Us'),
(25, 13, 'fr', 'CONSTRUIRE. ACQUÉRIR. CROÎTRE.'),
(26, 13, 'en', 'Build, acquire, grow'),
(27, 14, 'fr', 'Nous concevons des marques, sites web et systèmes d’acquisition qui transforment votre présence digitale en croissance mesurable.'),
(28, 14, 'en', 'We design high-converting brands, websites and acquisition systems that help ambitious businesses grow in Cameroon and across Africa.'),
(29, 15, 'fr', 'Stratégie Digitale'),
(30, 15, 'en', 'Digital Strategy'),
(31, 16, 'fr', 'Marketing d\'Acquisition'),
(32, 16, 'en', 'Growth Marketing'),
(33, 17, 'fr', 'Branding & Design'),
(34, 17, 'en', 'Brand & Design'),
(35, 18, 'fr', 'Qui nous sommes'),
(36, 18, 'en', 'Who we are'),
(37, 19, 'fr', 'Qui nous sommes'),
(38, 19, 'en', 'Who we are'),
(39, 20, 'fr', 'Innovation et croissance pour les entreprises digitales'),
(40, 20, 'en', 'Innovation and growth for digital businesses'),
(41, 21, 'fr', 'Innovation et croissance pour les entreprises digitales'),
(42, 21, 'en', 'Innovation and growth for digital businesses'),
(43, 22, 'fr', 'Nous sommes une agence digitale basée à Yaoundé, aidant les entreprises à créer des marques fortes, à convertir davantage de clients et à croître grâce à des expériences digitales performantes.'),
(44, 22, 'en', 'We are a Yaoundé-based digital agency helping businesses create strong online brands, convert more customers and scale through high-performance digital experiences.'),
(45, 23, 'fr', 'PDG, DB Digital Agency'),
(46, 23, 'en', 'CEO, DB Digital Agency'),
(47, 24, 'fr', 'DG, DB Digital Agency Douala'),
(48, 24, 'en', 'DG, DB Digital Agency Douala'),
(49, 25, 'fr', 'DG, DB Digital Agency Bafoussam'),
(50, 25, 'en', 'DG, DB Digital Agency Bafoussam'),
(51, 26, 'fr', 'Ce Que Nous Faisons Pour Vous'),
(52, 26, 'en', 'What We Do For You'),
(53, 27, 'fr', 'Une Large Gamme de Services Pour Votre Entreprise !'),
(54, 27, 'en', 'A Wide Range Of Services For Your Business!'),
(55, 28, 'fr', 'Voir Tous les Services'),
(56, 28, 'en', 'See All Services'),
(57, 29, 'fr', 'Nous fournissons des solutions digitales de bout en bout adaptées au contexte du marché africain et à vos besoins commerciaux spécifiques.'),
(58, 29, 'en', 'We provide end-to-end digital solutions tailored to the African market context and your specific business needs.'),
(59, 30, 'fr', 'Nos Services'),
(60, 30, 'en', 'Our Services'),
(61, 31, 'fr', 'De la stratégie à l’exécution : design, développement et marketing d’acquisition pour une présence digitale forte et des résultats mesurables.'),
(62, 31, 'en', 'From strategy to execution: design, development and growth marketing to build a strong digital presence and measurable results.'),
(63, 32, 'fr', 'Ce que nous faisons'),
(64, 32, 'en', 'What we do'),
(65, 33, 'fr', 'Une équipe digitale complète pour votre croissance'),
(66, 33, 'en', 'A complete digital team for your growth'),
(67, 34, 'fr', 'Demander un devis'),
(68, 34, 'en', 'Request a Quote'),
(69, 35, 'fr', 'Demander un devis'),
(70, 35, 'en', 'Request a quote'),
(71, 36, 'fr', 'Voir détails'),
(72, 36, 'en', 'See Details'),
(73, 37, 'fr', 'Besoin d’aide ? Contactez-nous'),
(74, 37, 'en', 'Need help? Contact us'),
(75, 38, 'fr', 'Obtenir un devis gratuit'),
(76, 38, 'en', 'Get a free quote'),
(77, 39, 'fr', 'Parlez-nous de votre projet — nous vous répondons sous un jour ouvré.'),
(78, 39, 'en', 'Tell us about your project — we reply within one business day.'),
(79, 40, 'fr', 'Questions fréquentes'),
(80, 40, 'en', 'Frequently asked questions'),
(81, 41, 'fr', 'Tous nos services'),
(82, 41, 'en', 'All our services'),
(83, 42, 'fr', 'Retour aux services'),
(84, 42, 'en', 'Back to services'),
(85, 43, 'fr', 'Ce que vous obtenez'),
(86, 43, 'en', 'What you get'),
(87, 44, 'fr', 'Projets Réalisés'),
(88, 44, 'en', 'Projects Delivered'),
(89, 45, 'fr', 'Clients Satisfaits'),
(90, 45, 'en', 'Satisfied Clients'),
(91, 46, 'fr', 'Récompenses Obtenues'),
(92, 46, 'en', 'Awards Earned'),
(93, 47, 'fr', 'Pays Desservis'),
(94, 47, 'en', 'Countries Served'),
(95, 48, 'fr', 'Appeler pour plus d\'infos'),
(96, 48, 'en', 'Call For More Info'),
(97, 49, 'fr', 'Demandez un rendez-vous pour une consultation gratuite'),
(98, 49, 'en', 'Let\'s Request a Schedule For Free Consultation'),
(99, 50, 'fr', 'Études de Cas'),
(100, 50, 'en', 'Case Studies'),
(101, 51, 'fr', 'Nous avons aidé des marques à croître grâce à des solutions digitales solides'),
(102, 51, 'en', 'We have helped brands grow with strong digital solutions'),
(103, 52, 'fr', 'Voir Tous les Projets'),
(104, 52, 'en', 'See All Projects'),
(105, 53, 'fr', 'Experts'),
(106, 53, 'en', 'Expert People'),
(107, 54, 'fr', 'Les Membres de Notre Équipe Dévouée'),
(108, 54, 'en', 'Our Dedicated Team Members'),
(109, 55, 'fr', 'Une équipe senior qui combine stratégie, design, ingénierie et performance marketing pour livrer des résultats business.'),
(110, 55, 'en', 'A lean senior team combining strategy, design, engineering and performance marketing to deliver tangible business outcomes.'),
(111, 56, 'fr', 'Stratège Digital'),
(112, 56, 'en', 'Digital Strategist'),
(113, 57, 'fr', 'Designer Graphique'),
(114, 57, 'en', 'Graphic Designer'),
(115, 58, 'fr', 'Développeur Web & Mobile'),
(116, 58, 'en', 'Web & Mobile Developer'),
(117, 59, 'fr', 'Community Manager'),
(118, 59, 'en', 'Community Manager'),
(119, 60, 'fr', 'Vidéaste Graphiste'),
(120, 60, 'en', 'Video Designer'),
(121, 61, 'fr', 'Directeur Marketing'),
(122, 61, 'en', 'Marketing Director'),
(123, 62, 'fr', 'Ce Que Disent Nos Clients'),
(124, 62, 'en', 'What Our Clients Say'),
(125, 63, 'fr', 'Actualités & Blogs'),
(126, 63, 'en', 'Insights & Articles'),
(127, 64, 'fr', 'Lisez Nos Dernières Mises à Jour'),
(128, 64, 'en', 'Read Our Latest Updates'),
(129, 65, 'fr', 'Analyses & Conseils'),
(130, 65, 'en', 'Insights'),
(131, 66, 'fr', 'Articles actionnables sur la stratégie, le design, le web, le SEO et l’acquisition pour les entreprises au Cameroun.'),
(132, 66, 'en', 'Actionable articles on strategy, design, web, SEO and acquisition for businesses in Cameroon.'),
(133, 67, 'fr', 'Aucun article ne correspond à vos critères.'),
(134, 67, 'en', 'No posts found matching your criteria.'),
(135, 68, 'fr', 'Catégories'),
(136, 68, 'en', 'Categories'),
(137, 69, 'fr', 'Articles récents'),
(138, 69, 'en', 'Recent Posts'),
(139, 70, 'fr', 'Tags'),
(140, 70, 'en', 'Tags'),
(141, 71, 'fr', 'Commercial'),
(142, 71, 'en', 'Sales'),
(143, 72, 'fr', 'Nouveaux projets et partenariats'),
(144, 72, 'en', 'For new projects and partnerships'),
(145, 73, 'fr', 'Général'),
(146, 73, 'en', 'General'),
(147, 74, 'fr', 'Questions, informations et orientation'),
(148, 74, 'en', 'Questions, information and orientation'),
(149, 75, 'fr', 'Support'),
(150, 75, 'en', 'Support'),
(151, 76, 'fr', 'Assistance technique et support'),
(152, 76, 'en', 'Technical support and assistance'),
(153, 77, 'fr', 'Contact'),
(154, 77, 'en', 'Contact'),
(155, 78, 'fr', 'Parlons de votre projet'),
(156, 78, 'en', 'Let\'s talk about your project'),
(157, 79, 'fr', 'Envoyez-nous un message ou repérez nos bureaux sur la carte — nous vous répondons rapidement.'),
(158, 79, 'en', 'Send us a message or find our offices on the map — we respond quickly.'),
(159, 80, 'fr', 'Écrivez-nous'),
(160, 80, 'en', 'Get in touch'),
(161, 81, 'fr', 'Envoyez-nous un message'),
(162, 81, 'en', 'Send us a message'),
(163, 82, 'fr', 'Parlez-nous de votre projet ou de votre question — nous répondons sous un jour ouvré.'),
(164, 82, 'en', 'Tell us about your project or question — we reply within one business day.'),
(165, 83, 'fr', 'Nom complet'),
(166, 83, 'en', 'Full name'),
(167, 84, 'fr', 'Téléphone'),
(168, 84, 'en', 'Phone'),
(169, 85, 'fr', 'Email'),
(170, 85, 'en', 'Email'),
(171, 86, 'fr', 'Message'),
(172, 86, 'en', 'Message'),
(173, 87, 'fr', 'ex. Jean Abena Njock'),
(174, 87, 'en', 'e.g. Jean Abena Njock'),
(175, 88, 'fr', '+237 6XX XXX XXX'),
(176, 88, 'en', '+237 6XX XXX XXX'),
(177, 89, 'fr', 'vous@entreprise.com'),
(178, 89, 'en', 'you@company.com'),
(179, 90, 'fr', 'Comment pouvons-nous vous aider ?'),
(180, 90, 'en', 'How can we help you?'),
(181, 91, 'fr', 'Envoyer le message'),
(182, 91, 'en', 'Send message'),
(183, 92, 'fr', 'Réponse sous 24 h ouvrées'),
(184, 92, 'en', 'Reply within 24 business hours'),
(185, 93, 'fr', 'Merci ! Votre message a été envoyé. Nous vous répondrons très bientôt.'),
(186, 93, 'en', 'Thank you! Your message has been sent. We will get back to you shortly.'),
(187, 94, 'fr', 'Merci ! Votre message a été enregistré. Notre équipe vous contactera rapidement.'),
(188, 94, 'en', 'Thank you! Your message has been saved. Our team will contact you shortly.'),
(189, 95, 'fr', 'Impossible d\'enregistrer votre message. Veuillez réessayer ou nous appeler.'),
(190, 95, 'en', 'Unable to save your message. Please try again or call us.'),
(191, 96, 'fr', 'Merci ! Vous êtes inscrit à notre newsletter.'),
(192, 96, 'en', 'Thank you! You are subscribed to our newsletter.'),
(193, 97, 'fr', 'Cet email est déjà inscrit à notre newsletter.'),
(194, 97, 'en', 'This email is already subscribed to our newsletter.'),
(195, 98, 'fr', 'Bon retour ! Votre abonnement à la newsletter est réactivé.'),
(196, 98, 'en', 'Welcome back! Your newsletter subscription is active again.'),
(197, 99, 'fr', 'Veuillez saisir une adresse email valide.'),
(198, 99, 'en', 'Please enter a valid email address.'),
(199, 100, 'fr', 'Impossible de vous inscrire pour le moment. Veuillez réessayer.'),
(200, 100, 'en', 'Unable to subscribe right now. Please try again later.'),
(201, 101, 'fr', 'Abonnez-vous à Notre Newsletter'),
(202, 101, 'en', 'Subscribe to Our Newsletter'),
(203, 102, 'fr', 'Inscrivez-vous à notre newsletter hebdomadaire pour recevoir les dernières actualités.'),
(204, 102, 'en', 'Sign up to our weekly newsletter to get the latest updates.'),
(205, 103, 'fr', 'entrez votre e-mail'),
(206, 103, 'en', 'enter your e-mail'),
(207, 104, 'fr', 'S\'abonner'),
(208, 104, 'en', 'Subscribe'),
(209, 105, 'fr', 'Nous ne vous envoyons pas de spam'),
(210, 105, 'en', 'We don\'t send you any spam'),
(211, 106, 'fr', 'Copyright © dbdigitalagency | Tous Droits Réservés'),
(212, 106, 'en', 'Copyright © dbdigitalagency | All Right Reserved'),
(213, 107, 'fr', 'Informations'),
(214, 107, 'en', 'Information'),
(215, 108, 'fr', 'Menu'),
(216, 108, 'en', 'Menu'),
(217, 109, 'fr', 'Lun – Sam : 8h – 18h'),
(218, 109, 'en', 'Mon – Sat: 8 am – 6 pm'),
(219, 110, 'fr', 'Dimanche'),
(220, 110, 'en', 'Sunday'),
(221, 111, 'fr', 'FERMÉ'),
(222, 111, 'en', 'CLOSED'),
(223, 112, 'fr', 'À propos'),
(224, 112, 'en', 'About us'),
(225, 113, 'fr', 'Carrières'),
(226, 113, 'en', 'Careers'),
(227, 114, 'fr', 'Presse'),
(228, 114, 'en', 'Press'),
(229, 115, 'fr', 'Politique de confidentialité'),
(230, 115, 'en', 'Privacy Policy'),
(231, 116, 'fr', 'Liens rapides'),
(232, 116, 'en', 'Quick Links'),
(233, 117, 'fr', 'Comment ça marche'),
(234, 117, 'en', 'How it works'),
(235, 118, 'fr', 'Partenaires'),
(236, 118, 'en', 'Partners'),
(237, 119, 'fr', 'Témoignages'),
(238, 119, 'en', 'Testimonials'),
(239, 120, 'fr', 'Études de cas'),
(240, 120, 'en', 'Case studies'),
(241, 121, 'fr', 'Tarification'),
(242, 121, 'en', 'Pricing'),
(243, 122, 'fr', 'Discuter sur WhatsApp'),
(244, 122, 'en', 'Chat on WhatsApp'),
(245, 123, 'fr', 'Demandez un Devis'),
(246, 123, 'en', 'Request a Quote'),
(247, 124, 'fr', 'Obtenez votre devis digital personnalisé aujourd\'hui'),
(248, 124, 'en', 'Get your custom digital quote today'),
(249, 125, 'fr', 'Parlez-nous de votre projet et nous vous proposerons une proposition adaptée à vos objectifs.'),
(250, 125, 'en', 'Tell us about your project and we will provide a tailored proposal that fits your goals.'),
(251, 126, 'fr', 'Réponse rapide'),
(252, 126, 'en', 'Fast response time'),
(253, 127, 'fr', 'Processus sécurisé et professionnel'),
(254, 127, 'en', 'Secure and professional process'),
(255, 128, 'fr', 'Parlez-nous'),
(256, 128, 'en', 'Talk to Us'),
(257, 129, 'fr', 'Service'),
(258, 129, 'en', 'Service'),
(259, 130, 'fr', 'Projet'),
(260, 130, 'en', 'Project'),
(261, 131, 'fr', 'Contact'),
(262, 131, 'en', 'Contact'),
(263, 132, 'fr', 'Revoir'),
(264, 132, 'en', 'Review'),
(265, 133, 'fr', 'Service'),
(266, 133, 'en', 'Service'),
(267, 134, 'fr', 'Sujet du Projet'),
(268, 134, 'en', 'Project Subject'),
(269, 135, 'fr', 'Type de Projet'),
(270, 135, 'en', 'Project Type'),
(271, 136, 'fr', 'Budget'),
(272, 136, 'en', 'Budget'),
(273, 137, 'fr', 'Date de début'),
(274, 137, 'en', 'Start Date'),
(275, 138, 'fr', 'Détails du Projet'),
(276, 138, 'en', 'Project Details'),
(277, 139, 'fr', 'Télécharger le Brief'),
(278, 139, 'en', 'Upload Brief'),
(279, 140, 'fr', 'Joignez ici tous les documents de projet pertinents.'),
(280, 140, 'en', 'Attach any relevant project documents here.'),
(281, 141, 'fr', 'Max. %s Mo'),
(282, 141, 'en', 'Max. %s MB'),
(283, 142, 'fr', 'Fichier trop volumineux (max. %s Mo).'),
(284, 142, 'en', 'File too large (max. %s MB).'),
(285, 143, 'fr', 'Nom Complet'),
(286, 143, 'en', 'Full Name'),
(287, 144, 'fr', 'Entreprise'),
(288, 144, 'en', 'Company'),
(289, 145, 'fr', 'Adresse Email'),
(290, 145, 'en', 'Email Address'),
(291, 146, 'fr', 'Numéro WhatsApp'),
(292, 146, 'en', 'WhatsApp Number'),
(293, 147, 'fr', 'Revoir'),
(294, 147, 'en', 'Review'),
(295, 148, 'fr', 'Envoyer la demande'),
(296, 148, 'en', 'Send Request'),
(297, 149, 'fr', 'L\'innovation commence ici'),
(298, 149, 'en', 'Innovation Starts Here'),
(299, 150, 'fr', 'Parlez-nous de ce que vous voulez construire. Nous vous répondons avec un plan clair, une timeline et une fourchette de budget — puis on affine ensemble.'),
(300, 150, 'en', 'Tell us what you want to build. We will reply with a clear plan, timeline and budget range — then we can refine together.'),
(301, 151, 'fr', 'Étape'),
(302, 151, 'en', 'Step'),
(303, 152, 'fr', 'sur'),
(304, 152, 'en', 'of'),
(305, 153, 'fr', 'Continuer'),
(306, 153, 'en', 'Continue'),
(307, 154, 'fr', 'Retour'),
(308, 154, 'en', 'Back'),
(309, 155, 'fr', 'Détails du projet'),
(310, 155, 'en', 'Project details'),
(311, 156, 'fr', 'Aidez-nous à comprendre le périmètre et la timeline de votre projet.'),
(312, 156, 'en', 'Help us understand the scope and timeline of your project.'),
(313, 157, 'fr', 'Vos informations'),
(314, 157, 'en', 'Your details'),
(315, 158, 'fr', 'Comment vous joindre ? Nous utiliserons ces infos pour vous répondre.'),
(316, 158, 'en', 'How can we reach you? We will use this to respond to your request.'),
(317, 159, 'fr', 'Vérifier & envoyer'),
(318, 159, 'en', 'Review & send'),
(319, 160, 'fr', 'Vérifiez votre demande avant l’envoi.'),
(320, 160, 'en', 'Review your request before sending.'),
(321, 161, 'fr', 'Sélectionnez un ou plusieurs services qui correspondent à votre besoin.'),
(322, 161, 'en', 'Select one or more services that match your needs.'),
(323, 162, 'fr', 'ex. Site e‑commerce'),
(324, 162, 'en', 'e.g. E‑commerce website'),
(325, 163, 'fr', 'Dites-nous en plus sur votre besoin...'),
(326, 163, 'en', 'Tell us more about your needs...'),
(327, 164, 'fr', 'Nom complet'),
(328, 164, 'en', 'Full name'),
(329, 165, 'fr', 'Nom de l’entreprise'),
(330, 165, 'en', 'Company name'),
(331, 166, 'fr', 'vous@email.com'),
(332, 166, 'en', 'your@email.com'),
(333, 167, 'fr', '+237 6XX XXX XXX'),
(334, 167, 'en', '+237 6XX XXX XXX'),
(335, 168, 'fr', 'Aucun fichier sélectionné'),
(336, 168, 'en', 'No file chosen'),
(337, 169, 'fr', 'Veuillez sélectionner au moins un service.'),
(338, 169, 'en', 'Please select at least one service.'),
(339, 170, 'fr', 'Requis'),
(340, 170, 'en', 'Required'),
(341, 171, 'fr', 'Email valide requis'),
(342, 171, 'en', 'Valid email required'),
(343, 172, 'fr', 'Envoyer la demande'),
(344, 172, 'en', 'Send request'),
(345, 173, 'fr', 'Email + WhatsApp'),
(346, 173, 'en', 'Email + WhatsApp'),
(347, 174, 'fr', 'Votre demande est envoyée par email à notre équipe et vous êtes redirigé vers WhatsApp pour finaliser.'),
(348, 174, 'en', 'Your request is emailed to our team and you will be redirected to WhatsApp to finalize.'),
(349, 175, 'fr', 'Stratégie Digitale'),
(350, 175, 'en', 'Digital Strategy'),
(351, 176, 'fr', 'Stratégie & conseil'),
(352, 176, 'en', 'Strategy & consulting'),
(353, 177, 'fr', 'Développement Web'),
(354, 177, 'en', 'Web Development'),
(355, 178, 'fr', 'Sites & apps'),
(356, 178, 'en', 'Websites & apps'),
(357, 179, 'fr', 'Branding & Design'),
(358, 179, 'en', 'Branding & Design'),
(359, 180, 'fr', 'UI/UX & identité'),
(360, 180, 'en', 'UI/UX & identity'),
(361, 181, 'fr', 'Marketing d’Acquisition'),
(362, 181, 'en', 'Growth Marketing'),
(363, 182, 'fr', 'SEO & acquisition'),
(364, 182, 'en', 'SEO & acquisition'),
(365, 183, 'fr', 'Nouveau projet'),
(366, 183, 'en', 'New project'),
(367, 184, 'fr', 'Refonte'),
(368, 184, 'en', 'Redesign'),
(369, 185, 'fr', 'Maintenance'),
(370, 185, 'en', 'Maintenance'),
(371, 186, 'fr', 'Conseil uniquement'),
(372, 186, 'en', 'Consulting only'),
(373, 187, 'fr', 'Immédiatement'),
(374, 187, 'en', 'Immediately'),
(375, 188, 'fr', 'Sous 1 semaine'),
(376, 188, 'en', 'Within 1 week'),
(377, 189, 'fr', 'Sous 1 mois'),
(378, 189, 'en', 'Within 1 month'),
(379, 190, 'fr', 'Flexible'),
(380, 190, 'en', 'Flexible'),
(381, 191, 'fr', 'optionnel'),
(382, 191, 'en', 'optional'),
(383, 192, 'fr', 'Envoyer par Email'),
(384, 192, 'en', 'Send by Email'),
(385, 193, 'fr', 'Envoyer via WhatsApp'),
(386, 193, 'en', 'Send via WhatsApp'),
(387, 194, 'fr', 'Méthode d\'envoi'),
(388, 194, 'en', 'Send Method'),
(389, 195, 'fr', 'Votre demande de devis a été envoyée avec succès ! Nous vous contacterons bientôt.'),
(390, 195, 'en', 'Your quote request has been sent successfully! We will contact you soon.'),
(391, 196, 'fr', 'Redirection vers WhatsApp...'),
(392, 196, 'en', 'Redirecting to WhatsApp...'),
(393, 197, 'fr', 'Impossible de sauvegarder votre demande. Veuillez réessayer.'),
(394, 197, 'en', 'Unable to save your request. Please try again.'),
(395, 198, 'fr', 'Demande sauvegardée mais l\'email a échoué. Nous vous contacterons via WhatsApp.'),
(396, 198, 'en', 'Request saved but email failed. We will contact you via WhatsApp.'),
(397, 199, 'fr', 'Bonjour DB Digital Agency, je souhaiterais un devis pour le projet suivant :'),
(398, 199, 'en', 'Hello DB Digital Agency, I would like a quote for the following project:'),
(399, 200, 'fr', 'Service'),
(400, 200, 'en', 'Service'),
(401, 201, 'fr', 'Sujet'),
(402, 201, 'en', 'Subject'),
(403, 202, 'fr', 'Type'),
(404, 202, 'en', 'Type'),
(405, 203, 'fr', 'Budget'),
(406, 203, 'en', 'Budget'),
(407, 204, 'fr', 'Début'),
(408, 204, 'en', 'Start'),
(409, 205, 'fr', 'Nom'),
(410, 205, 'en', 'Name'),
(411, 206, 'fr', 'Entreprise'),
(412, 206, 'en', 'Company'),
(413, 207, 'fr', 'Email'),
(414, 207, 'en', 'Email'),
(415, 208, 'fr', 'Message'),
(416, 208, 'en', 'Message'),
(417, 209, 'fr', 'Demande sauvegardée en base de données'),
(418, 209, 'en', 'Request saved in database'),
(419, 210, 'fr', 'Ils nous font confiance'),
(420, 210, 'en', 'Trusted by teams'),
(421, 211, 'fr', 'Quelques marques et partenaires avec qui nous avons collaboré.'),
(422, 211, 'en', 'A few brands and partners we’ve collaborated with.'),
(423, 212, 'fr', 'Nos bureaux'),
(424, 212, 'en', 'Our locations'),
(425, 213, 'fr', 'Présence nationale'),
(426, 213, 'en', 'Nationwide presence'),
(427, 214, 'fr', 'Trois points de contact au Cameroun pour vous accompagner en présentiel ou à distance.'),
(428, 214, 'en', 'Three contact points across Cameroon — visit us in person or work with us remotely.'),
(429, 215, 'fr', 'Cliquez sur une ville ou un marqueur sur la carte'),
(430, 215, 'en', 'Tap a city below or a marker on the map'),
(431, 216, 'fr', 'Voir sur la carte'),
(432, 216, 'en', 'View on map'),
(433, 217, 'fr', 'Bureau'),
(434, 217, 'en', 'Office'),
(435, 218, 'fr', 'Obtenir l’itinéraire'),
(436, 218, 'en', 'Get directions'),
(437, 219, 'fr', 'Accueil'),
(438, 219, 'en', 'Home'),
(439, 220, 'fr', 'À Propos'),
(440, 220, 'en', 'About'),
(441, 221, 'fr', 'Services'),
(442, 221, 'en', 'Services'),
(443, 222, 'fr', 'Projets'),
(444, 222, 'en', 'Projects'),
(445, 223, 'fr', 'Blog'),
(446, 223, 'en', 'Blog'),
(447, 224, 'fr', 'Contact'),
(448, 224, 'en', 'Contact'),
(449, 225, 'fr', 'Nous sommes une agence numérique de premier plan basée à Yaoundé, au Cameroun, aidant les entreprises à transformer leur présence numérique et à réaliser une croissance durable grâce à des stratégies innovantes.'),
(450, 225, 'en', 'We are a Yaoundé-based digital agency helping businesses create strong online brands, convert more customers and scale through high-performance digital experiences.'),
(451, 226, 'fr', 'Ans'),
(452, 226, 'en', 'Years'),
(453, 227, 'fr', 'd’expérience sur des projets digitaux'),
(454, 227, 'en', 'of experience building digital solutions'),
(455, 228, 'fr', 'Nous livrons des services digitaux de bout en bout — stratégie, design, développement et acquisition — pour faire croître votre marque avec des résultats mesurables.'),
(456, 228, 'en', 'We deliver end-to-end digital services — strategy, design, development and acquisition — to help brands grow with measurable results.'),
(457, 229, 'fr', 'Approche stratégie → exécution'),
(458, 229, 'en', 'Strategy-first approach, execution-ready'),
(459, 230, 'fr', 'UX et copy orientés conversion'),
(460, 230, 'en', 'Conversion-focused UX and copy'),
(461, 231, 'fr', 'SEO + performance par défaut'),
(462, 231, 'en', 'SEO + performance by default'),
(463, 232, 'fr', 'Campagnes optimisées pour le ROI'),
(464, 232, 'en', 'Campaigns optimized for ROI'),
(465, 233, 'fr', 'Notre équipe combine créativité et excellence technique pour transformer vos objectifs en système digital scalable.'),
(466, 233, 'en', 'Our team pairs creative and technical excellence to turn your objectives into a scalable digital system.'),
(467, 234, 'fr', 'Agence de Conseil Numérique et Croissance'),
(468, 234, 'en', 'Digital Consulting & Growth Agency'),
(469, 235, 'fr', 'Expertise en produit digital, croissance et branding'),
(470, 235, 'en', 'Digital product, growth and branding expertise'),
(471, 236, 'fr', 'Domaines d\'expertise'),
(472, 236, 'en', 'Expertise areas'),
(473, 237, 'fr', 'Nous aidons les marques à concevoir des parcours digitaux performants et à lancer des campagnes d\'acquisition qui génèrent une croissance mesurable.'),
(474, 237, 'en', 'We help brands design high-converting digital journeys and launch acquisition campaigns that deliver measurable growth.'),
(475, 238, 'fr', 'Stratégie Numérique'),
(476, 238, 'en', 'Digital Strategy'),
(477, 239, 'fr', 'Expérience de Marque'),
(478, 239, 'en', 'Brand Experience'),
(479, 240, 'fr', 'Croissance Commerciale'),
(480, 240, 'en', 'Customer Acquisition'),
(481, 241, 'fr', 'Utiliser nos Services'),
(482, 241, 'en', 'Start a Project'),
(483, 242, 'fr', 'Agence Créative Numérique'),
(484, 242, 'en', 'Digital Creative Agency'),
(485, 243, 'fr', 'Solutions Professionnelles'),
(486, 243, 'en', 'Professional Problem Solutions'),
(487, 244, 'fr', 'Design & Développement Web'),
(488, 244, 'en', 'Web Design & Development'),
(489, 245, 'fr', 'Solutions complètes pour votre croissance'),
(490, 245, 'en', 'Comprehensive solutions for your growth'),
(491, 246, 'fr', 'Rechercher ici...'),
(492, 246, 'en', 'Search Here...'),
(493, 247, 'fr', 'Recherchez ici'),
(494, 247, 'en', 'Search here'),
(495, 248, 'fr', 'Espace prospect'),
(496, 248, 'en', 'Prospect portal'),
(497, 249, 'fr', 'Accès à votre espace devis'),
(498, 249, 'en', 'Access your quote portal'),
(499, 250, 'fr', 'Utilisez le lien reçu par e-mail ou demandez un nouveau lien ci-dessous.'),
(500, 250, 'en', 'Use the link from your email or request a new one below.'),
(501, 251, 'fr', 'Lien invalide ou expiré.'),
(502, 251, 'en', 'Invalid or expired link.'),
(503, 252, 'fr', 'Lien expiré'),
(504, 252, 'en', 'Link expired'),
(505, 253, 'fr', 'Votre lien d\'accès a expiré. Cliquez pour recevoir un nouveau lien par e-mail.'),
(506, 253, 'en', 'Your access link has expired. Click below to receive a new link by email.'),
(507, 254, 'fr', 'Renvoyer le lien magique'),
(508, 254, 'en', 'Resend magic link'),
(509, 255, 'fr', 'Saisissez l\'e-mail utilisé lors de la demande et votre numéro de devis.'),
(510, 255, 'en', 'Enter the email used for your request and your quote number.'),
(511, 256, 'fr', 'Numéro de devis'),
(512, 256, 'en', 'Quote number'),
(513, 257, 'fr', 'Adresse e-mail'),
(514, 257, 'en', 'Email address'),
(515, 258, 'fr', 'Renvoyer le lien'),
(516, 258, 'en', 'Resend link'),
(517, 259, 'fr', 'Aucun devis trouvé pour ces informations.'),
(518, 259, 'en', 'No quote found for these details.'),
(519, 260, 'fr', 'Impossible d\'envoyer l\'e-mail. Réessayez plus tard.'),
(520, 260, 'en', 'Could not send the email. Please try again later.'),
(521, 261, 'fr', 'Un nouveau lien vous a été envoyé par e-mail.'),
(522, 261, 'en', 'A new link has been sent to your email.'),
(523, 262, 'fr', 'Retour'),
(524, 262, 'en', 'Back'),
(525, 263, 'fr', 'Suivi de votre devis'),
(526, 263, 'en', 'Your quote status'),
(527, 264, 'fr', 'Référence'),
(528, 264, 'en', 'Reference'),
(529, 265, 'fr', 'Sujet'),
(530, 265, 'en', 'Subject'),
(531, 266, 'fr', 'Service(s)'),
(532, 266, 'en', 'Service(s)'),
(533, 267, 'fr', 'Budget'),
(534, 267, 'en', 'Budget'),
(535, 268, 'fr', 'Soumis le'),
(536, 268, 'en', 'Submitted on'),
(537, 269, 'fr', 'Historique'),
(538, 269, 'en', 'Activity timeline'),
(539, 270, 'fr', 'Aucune activité pour le moment.'),
(540, 270, 'en', 'No activity yet.'),
(541, 271, 'fr', 'Documents'),
(542, 271, 'en', 'Documents'),
(543, 272, 'fr', 'Télécharger le brief'),
(544, 272, 'en', 'Download brief'),
(545, 273, 'fr', 'Aucun brief joint.'),
(546, 273, 'en', 'No brief attached.'),
(547, 274, 'fr', 'Document complémentaire (PDF, DOC, DOCX)'),
(548, 274, 'en', 'Additional document (PDF, DOC, DOCX)'),
(549, 275, 'fr', 'Envoyer le document'),
(550, 275, 'en', 'Upload document'),
(551, 276, 'fr', 'Fichier invalide.'),
(552, 276, 'en', 'Invalid file.'),
(553, 277, 'fr', 'Fichier trop volumineux.'),
(554, 277, 'en', 'File is too large.'),
(555, 278, 'fr', 'Échec de l\'envoi.'),
(556, 278, 'en', 'Upload failed.'),
(557, 279, 'fr', 'Document envoyé avec succès.'),
(558, 279, 'en', 'Document uploaded successfully.'),
(559, 280, 'fr', 'Nous contacter'),
(560, 280, 'en', 'Contact us'),
(561, 281, 'fr', 'WhatsApp'),
(562, 281, 'en', 'WhatsApp'),
(563, 282, 'fr', 'E-mail'),
(564, 282, 'en', 'Email'),
(565, 283, 'fr', 'Session expirée. Reconnectez-vous via votre lien magique.'),
(566, 283, 'en', 'Session expired. Please sign in again via your magic link.'),
(567, 284, 'fr', 'Nouveau'),
(568, 284, 'en', 'New'),
(569, 285, 'fr', 'Contacté'),
(570, 285, 'en', 'Contacted'),
(571, 286, 'fr', 'En cours'),
(572, 286, 'en', 'In progress'),
(573, 287, 'fr', 'Terminé'),
(574, 287, 'en', 'Completed'),
(575, 288, 'fr', 'Annulé'),
(576, 288, 'en', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_message` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', NULL, NULL, 0, NULL, '2026-06-08 15:19:41', '2026-06-08 15:19:41', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_category_translations`
--
ALTER TABLE `blog_category_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id_locale` (`category_id`,`locale`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_post_translations`
--
ALTER TABLE `blog_post_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id_locale` (`post_id`,`locale`);

--
-- Indexes for table `brand_logos`
--
ALTER TABLE `brand_logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_translations`
--
ALTER TABLE `faq_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faq_id_locale` (`faq_id`,`locale`);

--
-- Indexes for table `homepage_sections`
--
ALTER TABLE `homepage_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_translations`
--
ALTER TABLE `media_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_translations_media_id_foreign` (`media_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `menu_item_translations`
--
ALTER TABLE `menu_item_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_item_id_locale` (`menu_item_id`,`locale`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `office_locations`
--
ALTER TABLE `office_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_location_translations`
--
ALTER TABLE `office_location_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `location_id_locale` (`location_id`,`locale`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_translations`
--
ALTER TABLE `page_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_id_locale` (`page_id`,`locale`),
  ADD KEY `locale_slug` (`locale`,`slug`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `project_translations`
--
ALTER TABLE `project_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id_locale` (`project_id`,`locale`);

--
-- Indexes for table `prospect_activity_logs`
--
ALTER TABLE `prospect_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prospect_activity_logs_quote_id_foreign` (`quote_id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_token` (`access_token`),
  ADD KEY `email` (`email`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `quote_documents`
--
ALTER TABLE `quote_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_id` (`quote_id`);

--
-- Indexes for table `quote_logs`
--
ALTER TABLE `quote_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_logs_quote_id_foreign` (`quote_id`);

--
-- Indexes for table `quote_services`
--
ALTER TABLE `quote_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_services_quote_id_foreign` (`quote_id`);

--
-- Indexes for table `section_translations`
--
ALTER TABLE `section_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_id_locale` (`section_id`,`locale`);

--
-- Indexes for table `seo_meta`
--
ALTER TABLE `seo_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `entity_type_entity_id_locale` (`entity_type`,`entity_id`,`locale`);

--
-- Indexes for table `seo_redirects`
--
ALTER TABLE `seo_redirects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_path` (`from_path`);

--
-- Indexes for table `seo_sitemap_config`
--
ALTER TABLE `seo_sitemap_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `entity_type` (`entity_type`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `service_faqs`
--
ALTER TABLE `service_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_faqs_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_translations`
--
ALTER TABLE `service_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_id_locale` (`service_id`,`locale`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_branding`
--
ALTER TABLE `site_branding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_member_translations`
--
ALTER TABLE `team_member_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_member_id_locale` (`team_member_id`,`locale`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial_translations`
--
ALTER TABLE `testimonial_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `testimonial_id_locale` (`testimonial_id`,`locale`);

--
-- Indexes for table `translation_keys`
--
ALTER TABLE `translation_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `translation_values`
--
ALTER TABLE `translation_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_id_locale` (`key_id`,`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blog_category_translations`
--
ALTER TABLE `blog_category_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_post_translations`
--
ALTER TABLE `blog_post_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `brand_logos`
--
ALTER TABLE `brand_logos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq_translations`
--
ALTER TABLE `faq_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `homepage_sections`
--
ALTER TABLE `homepage_sections`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `media_translations`
--
ALTER TABLE `media_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu_item_translations`
--
ALTER TABLE `menu_item_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `office_locations`
--
ALTER TABLE `office_locations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `office_location_translations`
--
ALTER TABLE `office_location_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `page_translations`
--
ALTER TABLE `page_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project_translations`
--
ALTER TABLE `project_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prospect_activity_logs`
--
ALTER TABLE `prospect_activity_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_documents`
--
ALTER TABLE `quote_documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_logs`
--
ALTER TABLE `quote_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_services`
--
ALTER TABLE `quote_services`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_translations`
--
ALTER TABLE `section_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seo_meta`
--
ALTER TABLE `seo_meta`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `seo_redirects`
--
ALTER TABLE `seo_redirects`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `seo_sitemap_config`
--
ALTER TABLE `seo_sitemap_config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_faqs`
--
ALTER TABLE `service_faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `service_translations`
--
ALTER TABLE `service_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_branding`
--
ALTER TABLE `site_branding`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `team_member_translations`
--
ALTER TABLE `team_member_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonial_translations`
--
ALTER TABLE `testimonial_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `translation_keys`
--
ALTER TABLE `translation_keys`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT for table `translation_values`
--
ALTER TABLE `translation_values`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=577;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_category_translations`
--
ALTER TABLE `blog_category_translations`
  ADD CONSTRAINT `blog_category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_post_translations`
--
ALTER TABLE `blog_post_translations`
  ADD CONSTRAINT `blog_post_translations_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faq_translations`
--
ALTER TABLE `faq_translations`
  ADD CONSTRAINT `faq_translations_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `service_faqs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media_translations`
--
ALTER TABLE `media_translations`
  ADD CONSTRAINT `media_translations_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_item_translations`
--
ALTER TABLE `menu_item_translations`
  ADD CONSTRAINT `menu_item_translations_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `office_location_translations`
--
ALTER TABLE `office_location_translations`
  ADD CONSTRAINT `office_location_translations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `office_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `page_translations`
--
ALTER TABLE `page_translations`
  ADD CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_translations`
--
ALTER TABLE `project_translations`
  ADD CONSTRAINT `project_translations_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prospect_activity_logs`
--
ALTER TABLE `prospect_activity_logs`
  ADD CONSTRAINT `prospect_activity_logs_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quote_logs`
--
ALTER TABLE `quote_logs`
  ADD CONSTRAINT `quote_logs_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quote_services`
--
ALTER TABLE `quote_services`
  ADD CONSTRAINT `quote_services_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `section_translations`
--
ALTER TABLE `section_translations`
  ADD CONSTRAINT `section_translations_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `homepage_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_faqs`
--
ALTER TABLE `service_faqs`
  ADD CONSTRAINT `service_faqs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_translations`
--
ALTER TABLE `service_translations`
  ADD CONSTRAINT `service_translations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_member_translations`
--
ALTER TABLE `team_member_translations`
  ADD CONSTRAINT `team_member_translations_team_member_id_foreign` FOREIGN KEY (`team_member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testimonial_translations`
--
ALTER TABLE `testimonial_translations`
  ADD CONSTRAINT `testimonial_translations_testimonial_id_foreign` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `translation_values`
--
ALTER TABLE `translation_values`
  ADD CONSTRAINT `translation_values_key_id_foreign` FOREIGN KEY (`key_id`) REFERENCES `translation_keys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
