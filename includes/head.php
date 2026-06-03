<?php
// includes/head.php
require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html class="no-js" lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $page_title ?? SITE_NAME; ?> - <?php echo __('meta_suffix'); ?></title>
    <meta name="description" content="<?php echo $page_description ?? __('meta_default_description'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        $reqUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = strtok($reqUri, '?') ?: '/';
        $query = $_GET ?? [];
        $query['lang'] = $current_lang;
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $siteUrl = SITE_URL !== '' ? SITE_URL : ($scheme . '://' . $host);
        $canonical = rtrim($siteUrl, '/') . '/' . ltrim($path, '/');
        $canonical = strtok($canonical, '?');

        // SEO index/noindex piloté par env
        $seoIndex = env_bool('SEO_INDEX', true);
        $robotsMeta = $seoIndex ? 'index,follow' : 'noindex,nofollow';

        // hreflang
        $queryFr = $query; $queryFr['lang'] = 'fr';
        $queryEn = $query; $queryEn['lang'] = 'en';
        $hrefFr = rtrim($siteUrl, '/') . '/' . ltrim($path, '/') . '?' . http_build_query($queryFr);
        $hrefEn = rtrim($siteUrl, '/') . '/' . ltrim($path, '/') . '?' . http_build_query($queryEn);
        $ogTitle = ($page_title ?? SITE_NAME) . ' - ' . __('meta_suffix');
        $ogDesc = $page_description ?? __('meta_default_description');
        $ogUrl = $canonical . ($current_lang ? '?lang=' . $current_lang : '');
        $ogLocale = $current_lang === 'fr' ? 'fr_FR' : 'en_US';
    ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
    <meta name="robots" content="<?php echo $robotsMeta; ?>">
    <link rel="alternate" hreflang="fr" href="<?php echo htmlspecialchars($hrefFr); ?>">
    <link rel="alternate" hreflang="en" href="<?php echo htmlspecialchars($hrefEn); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo htmlspecialchars($hrefFr); ?>">

    <!-- Open Graph -->
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDesc); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($ogUrl); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?php echo $ogLocale; ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($ogDesc); ?>">

    <!-- Structured Data: Organization -->
    <script type="application/ld+json"><?php
        echo json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => SITE_NAME,
            'url' => rtrim((string) $siteUrl, '/'),
            'email' => CONTACT_EMAIL,
            'telephone' => CONTACT_PHONE_1,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => CONTACT_ADDRESS,
                'addressCountry' => 'CM',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    ?></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo ASSETS_URL; ?>img/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/animate.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/flaticon.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/odometer.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/jarallax.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/slick.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/aos.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/default.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/responsive.css">
    
    <!-- Custom CSS (WhatsApp + Lang Switcher) -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/custom.css">
    
    <!-- FontAwesome Brands (pour WhatsApp icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>