<?php
// includes/functions.php
require_once __DIR__ . '/config.php';

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