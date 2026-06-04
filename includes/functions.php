<?php
// includes/functions.php

// ============================================
// Bootstrap (env + session + langue + config)
// ============================================
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

if (class_exists(\Dotenv\Dotenv::class) && file_exists(__DIR__ . '/../.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();
}

function envv(string $key, $default = null) {
    $val = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    if ($val === false || $val === null || $val === '') return $default;
    return $val;
}

function env_bool(string $key, bool $default = false): bool {
    $v = strtolower((string) envv($key, $default ? 'true' : 'false'));
    return in_array($v, ['1','true','yes','on'], true);
}

function env_int(string $key, int $default = 0): int {
    $v = envv($key, null);
    return is_numeric($v) ? (int) $v : $default;
}

// Session + i18n
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$available_langs = ['en', 'fr'];
$default_lang = 'fr';

if (isset($_GET['lang']) && in_array($_GET['lang'], $available_langs, true)) {
    $_SESSION['lang'] = $_GET['lang'];
    $current_lang = $_GET['lang'];
} elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $available_langs, true)) {
    $current_lang = $_SESSION['lang'];
} else {
    $current_lang = $default_lang;
}

require_once __DIR__ . '/config.php';

function __($key) {
    global $translations, $current_lang;
    return $translations[$current_lang][$key] ?? ($translations['en'][$key] ?? $key);
}

// WhatsApp message selon la langue
$whatsapp_messages = [
    'en' => 'Hello DB Digital Agency, I would like a tailored quote for my digital project.',
    'fr' => 'Bonjour DB Digital Agency, je souhaite un devis personnalisé pour mon projet digital.',
];
if (!defined('WHATSAPP_MESSAGE')) {
    define('WHATSAPP_MESSAGE', $whatsapp_messages[$current_lang] ?? $whatsapp_messages['fr']);
}

/**
 * Retourne la classe 'active' si la page courante correspond
 */
function isActive($page_filename) {
    $current = basename($_SERVER['PHP_SELF']);
    return ($current === $page_filename) ? 'active' : '';
}

/**
 * Génère les icônes sociales
 */
function renderSocialIcons($class = '') {
    global $social_links;
    $html = '<ul class="list-wrap ' . $class . '">';
    foreach ($social_links as $network => $url) {
        $icon = match($network) {
            'facebook'  => 'fa-facebook-f',
            'twitter'   => 'fa-twitter',
            'instagram' => 'fa-instagram',
            'linkedin'  => 'fa-linkedin-in',
            'youtube'   => 'fa-youtube',
            'pinterest' => 'fa-pinterest-p',
            default     => 'fa-globe'
        };
        $html .= '<li><a href="' . $url . '"><i class="fab ' . $icon . '"></i></a></li>';
    }
    return $html . '</ul>';
}

/**
 * Retourne le texte traduit d'un article de blog
 */
function getBlogField($post, $field) {
    global $current_lang;
    $suffix = $current_lang === 'fr' ? '_fr' : '_en';
    return $post[$field . $suffix] ?? $post[$field . '_en'] ?? '';
}

/**
 * Retourne le texte traduit d'une catégorie
 */
function getCategoryField($cat, $field = 'name') {
    global $current_lang;
    $suffix = $current_lang === 'fr' ? '_fr' : '_en';
    return $cat[$field . $suffix] ?? $cat[$field . '_en'] ?? '';
}

/**
 * Icône Font Awesome cohérente pour les boutons du site.
 */
function btnIcon(string $type): string {
    $icons = [
        'quote'     => 'fas fa-file-invoice',
        'read_more' => 'fas fa-book-open',
        'services'  => 'fas fa-briefcase',
        'projects'  => 'fas fa-folder-open',
        'contact'   => 'fas fa-envelope',
        'subscribe' => 'fas fa-paper-plane',
        'whatsapp'  => 'fab fa-whatsapp',
        'details'   => 'fas fa-arrow-right',
        'send'      => 'fas fa-paper-plane',
    ];
    $class = $icons[$type] ?? 'fas fa-arrow-right';
    return '<i class="' . $class . ' btn-i" aria-hidden="true"></i>';
}

/**
 * Génère un lien URL avec paramètre de langue
 */
function getPageLink($page) {
    global $current_lang;
    return $page . ($current_lang !== 'en' ? '?lang=' . $current_lang : '');
}

/**
 * Génère une URL de langue avec préservation du lien
 */
function getLangUrl($page = '', $lang = null) {
    global $current_lang;
    if (empty($page)) {
        $page = basename($_SERVER['SCRIPT_FILENAME']) ?: basename($_SERVER['SCRIPT_NAME']);
    }

    $targetLang = $lang ?? $current_lang;
    $query = $_GET;
    $query['lang'] = $targetLang;

    return $page . '?' . http_build_query($query);
}
?>