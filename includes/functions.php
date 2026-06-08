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

if (!defined('WHATSAPP_MESSAGE')) {
    global $whatsapp_messages;
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
 * Normalise une URL de réseau social (ajoute https:// si absent).
 */
function socialUrl(string $url): string {
    $url = trim($url);
    if ($url === '') {
        return '#';
    }
    if (!preg_match('#^https?://#i', $url)) {
        $url = 'https://' . ltrim($url, '/');
    }
    return $url;
}

/**
 * Génère les icônes sociales depuis $social_links (config.php).
 */
function renderSocialIcons($class = '') {
    global $social_links;
    $labels = [
        'facebook'  => 'Facebook',
        'tiktok'    => 'TikTok',
        'youtube'   => 'YouTube',
        'linkedin'  => 'LinkedIn',
        'instagram' => 'Instagram',
        'twitter'   => 'X',
        'pinterest' => 'Pinterest',
    ];
    $html = '<ul class="list-wrap ' . htmlspecialchars(trim($class), ENT_QUOTES, 'UTF-8') . '">';
    foreach ($social_links as $network => $url) {
        $icon = match ($network) {
            'facebook'  => 'fa-facebook-f',
            'tiktok'    => 'fa-tiktok',
            'youtube'   => 'fa-youtube',
            'linkedin'  => 'fa-linkedin-in',
            'instagram' => 'fa-instagram',
            'twitter', 'x' => 'fa-x-twitter',
            'pinterest' => 'fa-pinterest-p',
            default     => 'fa-globe',
        };
        $href = socialUrl((string) $url);
        $label = $labels[$network] ?? ucfirst((string) $network);
        $html .= '<li><a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '"'
            . ' target="_blank" rel="noopener noreferrer"'
            . ' aria-label="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '">'
            . '<i class="fab ' . $icon . '" aria-hidden="true"></i></a></li>';
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

/**
 * URL d'image témoignage avec repli sur temoignage.png
 */
function testimonialImageUrl(string $filename): string {
    $path = __DIR__ . '/../assets/img/images/' . $filename;
    if (is_file($path)) {
        return ASSETS_URL . 'img/images/' . $filename;
    }
    return ASSETS_URL . 'img/images/temoignage.png';
}

/**
 * Retourne le texte traduit d'un service (champs suffixés _en / _fr).
 */
function getServiceField(array $service, string $field) {
    global $current_lang;
    $suffix = $current_lang === 'fr' ? '_fr' : '_en';
    return $service[$field . $suffix] ?? $service[$field . '_en'] ?? '';
}

/**
 * Retourne un service par son slug ou null.
 */
function getServiceBySlug(string $slug): ?array {
    global $agency_services;
    foreach ($agency_services as $service) {
        if (($service['slug'] ?? '') === $slug) {
            return $service;
        }
    }
    return null;
}

/**
 * Lien vers la page détail d'un service.
 */
function getServiceLink(string $slug): string {
    global $current_lang;
    $url = 'services-details.php?service=' . rawurlencode($slug);
    if ($current_lang !== 'en') {
        $url .= '&lang=' . $current_lang;
    }
    return $url;
}

/**
 * Retourne le texte traduit d'un élément de contenu (_en / _fr).
 */
function getContentField(array $item, string $field) {
    global $current_lang;
    $suffix = $current_lang === 'fr' ? '_fr' : '_en';
    return $item[$field . $suffix] ?? $item[$field . '_en'] ?? '';
}

/**
 * Retourne le texte traduit d'un projet affiché sur l'accueil.
 */
function getProjectField(array $project, string $field) {
    return getContentField($project, $field);
}

/**
 * Retourne le texte traduit d'un témoignage.
 */
function getTestimonialField(array $item, string $field) {
    return getContentField($item, $field);
}

/**
 * Prépare les données carte à partir des bureaux (config).
 */
function buildMapLocations(array $locations): array {
    global $current_lang;
    $result = [];
    foreach ($locations as $loc) {
        $key = (string) ($loc['key'] ?? '');
        $image = (string) ($loc['image'] ?? '');
        if ($image !== '' && !preg_match('#^https?://#i', $image)) {
            $image = ASSETS_URL . 'img/images/' . ltrim($image, '/');
        }
        $result[] = [
            'key' => $key,
            'city' => (string) ($loc['city'] ?? ''),
            'label' => $current_lang === 'fr'
                ? (string) ($loc['label_fr'] ?? $loc['label_en'] ?? '')
                : (string) ($loc['label_en'] ?? ''),
            'address' => (string) ($loc['address'] ?? ''),
            'phone' => (string) ($loc['phone'] ?? ''),
            'email' => (string) ($loc['email'] ?? ''),
            'lat' => (float) ($loc['lat'] ?? 0),
            'lng' => (float) ($loc['lng'] ?? 0),
            'zoom' => (int) ($loc['zoom'] ?? 14),
            'image' => $image,
            'badge' => (string) ($loc['badge'] ?? __('locations_badge')),
        ];
    }
    return $result;
}

/**
 * Logos marques pour la grille (avec doublons optionnels).
 */
function getBrandLogosDisplay(): array {
    global $brand_logos, $brand_logos_extra;
    return array_merge($brand_logos ?? [], $brand_logos_extra ?? []);
}
?>