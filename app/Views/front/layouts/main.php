<?php
$locale         = $locale ?? service('request')->getLocale();
$pageTitle      = $pageTitle ?? site_trans('meta_suffix', $locale);
$pageDescription= $pageDescription ?? site_trans('meta_default_description', $locale);
$siteName       = $siteName ?? 'DB Digital Agency';
$isHome         = $isHome ?? false;
$seoIndex       = $seoIndex ?? true;
$hrefFr         = lang_url('fr');
$hrefEn         = lang_url('en');
$integrations   = $integrations ?? service('siteSettings')->integrations();
$pageSeo        = $pageSeo ?? service('seoPresentation')->build([
    'title'       => $pageTitle,
    'description' => $pageDescription,
    'locale'      => $locale,
    'siteName'    => $siteName,
    'seoIndex'    => $seoIndex,
    'schemas'     => [service('schema')->organization([
        'name'    => $siteName,
        'email'   => $contactEmail ?? '',
        'phone'   => $contactPhone1 ?? '',
        'address' => $contactAddress ?? '',
    ])],
]);
$prospectLoggedIn  = (bool) session()->get('prospect_quote_id');
$deferScripts      = $integrations['defer_scripts'] ?? true;
$scriptDefer       = $deferScripts ? ' defer' : '';
?>
<!doctype html>
<html class="no-js" lang="<?= esc($locale) ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= esc($pageSeo['fullTitle'] ?? $pageTitle) ?></title>
    <meta name="description" content="<?= esc($pageSeo['description'] ?? $pageDescription) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="<?= esc($pageSeo['canonical'] ?? current_url(), 'attr') ?>">
    <meta name="robots" content="<?= esc($pageSeo['robots'] ?? 'index,follow', 'attr') ?>">
    <link rel="alternate" hreflang="fr" href="<?= esc($hrefFr, 'attr') ?>">
    <link rel="alternate" hreflang="en" href="<?= esc($hrefEn, 'attr') ?>">
    <link rel="alternate" hreflang="x-default" href="<?= esc($hrefFr, 'attr') ?>">
    <meta property="og:site_name" content="<?= esc($siteName) ?>">
    <meta property="og:title" content="<?= esc($pageSeo['ogTitle'] ?? $pageTitle, 'attr') ?>">
    <meta property="og:description" content="<?= esc($pageSeo['ogDescription'] ?? $pageDescription, 'attr') ?>">
    <meta property="og:url" content="<?= esc($pageSeo['canonical'] ?? current_url(), 'attr') ?>">
    <meta property="og:type" content="<?= esc($pageSeo['ogType'] ?? 'website', 'attr') ?>">
    <meta property="og:locale" content="<?= esc($pageSeo['ogLocale'] ?? 'fr_FR') ?>">
    <?php if (! empty($pageSeo['ogImage'])): ?>
    <meta property="og:image" content="<?= esc($pageSeo['ogImage'], 'attr') ?>">
    <meta name="twitter:image" content="<?= esc($pageSeo['ogImage'], 'attr') ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="<?= esc($pageSeo['twitterCard'] ?? 'summary_large_image', 'attr') ?>">
    <meta name="twitter:title" content="<?= esc($pageSeo['ogTitle'] ?? $pageTitle, 'attr') ?>">
    <meta name="twitter:description" content="<?= esc($pageSeo['ogDescription'] ?? $pageDescription, 'attr') ?>">
    <?php foreach (($pageSeo['schemas'] ?? []) as $schema): ?>
    <?php if (is_array($schema) && $schema !== []): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <?php endif; ?>
    <?php endforeach; ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= esc($favicon ?? asset_url('img/favicon.png'), 'attr') ?>">
    <?php if ($integrations['preload_fonts'] ?? false): ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php endif; ?>
    <link rel="stylesheet" href="<?= asset_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/magnific-popup.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/fontawesome-all.min.css') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/flaticon.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/odometer.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/jarallax.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= asset_url('css/swiper-bundle.min.css') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/slick.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/aos.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/default.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/style.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/responsive.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/custom.css', true), 'attr') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body<?= ! empty($trackConversion) ? ' data-track-conversion="' . esc($trackConversion, 'attr') . '"' : '' ?>>
    <?= view('front/partials/cookie-consent', compact('locale', 'integrations')) ?>
    <div id="preloader">
        <div id="loading-center">
            <div class="loader"><div class="loader-outter"></div><div class="loader-inner"></div></div>
        </div>
    </div>
    <button class="scroll-top scroll-to-target" data-target="html"><i class="fas fa-angle-up"></i></button>

    <?php if (! $isHome): ?><div id="header-fixed-height"></div><?php endif; ?>

    <header class="<?= $isHome ? 'transparent-header' : 'header-style-six' ?>">
        <div class="heder-top-wrap">
            <div class="container custom-container-seven">
                <div class="row align-items-center">
                    <div class="col-12 col-md-7">
                        <div class="header-top-left">
                            <ul class="list-wrap">
                                <li class="d-none d-md-flex"><i class="flaticon-location"></i><?= esc($contactAddress ?? '') ?></li>
                                <li class="d-none d-lg-flex"><i class="flaticon-mail"></i><a href="mailto:<?= esc($contactEmail ?? '', 'attr') ?>"><?= esc($contactEmail ?? '') ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="header-top-right">
                            <div class="header-contact">
                                <a href="tel:<?= esc(preg_replace('/\s+/', '', (string) ($contactPhone1 ?? '')), 'attr') ?>">
                                    <i class="flaticon-phone-call"></i><?= esc($contactPhone1 ?? '') ?>
                                </a>
                            </div>
                            <div class="header-social">
                                <?= social_icons_html($socialLinks ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="sticky-header" class="<?= $isHome ? 'menu-area menu-area-six' : 'menu-area' ?>">
            <div class="container<?= $isHome ? ' custom-container-seven' : '' ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="menu-wrap">
                            <nav class="menu-nav">
                                <div class="logo">
                                    <a href="<?= page_url('home', $locale) ?>">
                                        <img src="<?= esc($isHome ? ($logoLight ?? asset_url('img/logo/w_logo02.png')) : ($logoDark ?? asset_url('img/logo/logo.png')), 'attr') ?>" alt="Logo">
                                    </a>
                                </div>
                                <div class="navbar-wrap main-menu d-none d-lg-flex">
                                    <ul class="navigation">
                                        <?php foreach ($navItems as $item): ?>
                                        <li class="<?= esc(is_nav_active((string) ($item['url'] ?? '')) . ' ' . ($item['css_class'] ?? ''), 'attr') ?>">
                                            <a href="<?= esc((string) ($item['url'] ?? '#'), 'attr') ?>"><?= esc((string) ($item['label'] ?? '')) ?></a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="header-nav-right">
                                    <div class="header-action<?= $isHome ? ' header-action-six' : '' ?>">
                                        <ul class="list-wrap">
                                            <li class="header-search d-none d-lg-block"><a href="#"><i class="flaticon-search"></i></a></li>
                                            <li class="header-prospect-auth d-none d-lg-block">
                                                <?php if ($prospectLoggedIn): ?>
                                                    <a href="<?= site_url('prospect/logout') ?>"
                                                       title="<?= esc(site_trans('header_prospect_logout', $locale)) ?>"
                                                       aria-label="<?= esc(site_trans('header_prospect_logout', $locale)) ?>">
                                                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= site_url('user/login') ?>"
                                                       title="<?= esc(site_trans('header_prospect_login', $locale)) ?>"
                                                       aria-label="<?= esc(site_trans('header_prospect_login', $locale)) ?>">
                                                        <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                            <li class="header-btn<?= $isHome ? '' : ' d-none d-lg-block' ?>">
                                                <a href="<?= page_url('get-quote', $locale) ?>" class="btn btn-two btn-has-i"><?= btn_icon('quote') ?><?= esc(site_trans('btn_quote', $locale)) ?></a>
                                            </li>
                                            <li class="header-lang d-none d-lg-block">
                                                <div class="lang-switcher">
                                                    <a href="<?= esc(lang_url('fr'), 'attr') ?>" class="lang-fr <?= $locale === 'fr' ? 'active' : '' ?>" title="Français">FR</a>
                                                    <a href="<?= esc(lang_url('en'), 'attr') ?>" class="lang-en <?= $locale === 'en' ? 'active' : '' ?>" title="English">EN</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                                </div>
                            </nav>
                        </div>
                        <div class="mobile-menu">
                            <nav class="menu-box">
                                <div class="close-btn"><i class="fas fa-times"></i></div>
                                <div class="nav-logo">
                                    <a href="<?= page_url('home', $locale) ?>">
                                        <img src="<?= esc($logoDark ?? asset_url('img/logo/logo.png'), 'attr') ?>" alt="Logo">
                                    </a>
                                </div>
                                <div class="mobile-search">
                                    <form action="#"><input type="text" placeholder="<?= esc(site_trans('search_placeholder', $locale)) ?>"><button><i class="flaticon-search"></i></button></form>
                                </div>
                                <div class="menu-outer"></div>
                                <div class="header-action header-action-six">
                                    <ul class="list-wrap">
                                        <li class="header-prospect-auth">
                                            <?php if ($prospectLoggedIn): ?>
                                                <a href="<?= site_url('prospect/logout') ?>"
                                                   title="<?= esc(site_trans('header_prospect_logout', $locale)) ?>"
                                                   aria-label="<?= esc(site_trans('header_prospect_logout', $locale)) ?>">
                                                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                                                    <span><?= esc(site_trans('header_prospect_logout', $locale)) ?></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= site_url('user/login') ?>"
                                                   title="<?= esc(site_trans('header_prospect_login', $locale)) ?>"
                                                   aria-label="<?= esc(site_trans('header_prospect_login', $locale)) ?>">
                                                    <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                                                    <span><?= esc(site_trans('header_prospect_login', $locale)) ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                        <li class="header-btn"><a href="<?= page_url('get-quote', $locale) ?>" class="btn btn-two btn-has-i"><?= btn_icon('quote') ?><?= esc(site_trans('btn_quote', $locale)) ?></a></li>
                                    </ul>
                                </div>
                                <div class="lang-switcher">
                                    <a href="<?= esc(lang_url('fr'), 'attr') ?>" class="lang-fr <?= $locale === 'fr' ? 'active' : '' ?>" title="Français">FR</a>
                                    <a href="<?= esc(lang_url('en'), 'attr') ?>" class="lang-en <?= $locale === 'en' ? 'active' : '' ?>" title="English">EN</a>
                                </div>
                                <div class="social-links">
                                    <?= social_icons_html($socialLinks ?? null, 'clearfix') ?>
                                </div>
                            </nav>
                        </div>
                        <div class="menu-backdrop"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-popup-wrap" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="search-close"><span><i class="fas fa-times"></i></span></div>
            <div class="search-wrap text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="title">... <?= esc(site_trans('search_title', $locale)) ?> ...</h2>
                            <div class="search-form">
                                <form action="#"><input type="text" name="search" placeholder="<?= esc(site_trans('search_placeholder', $locale)) ?>"><button class="search-btn"><i class="fas fa-search"></i></button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?= $this->renderSection('content') ?>

    <?php
    $footerLegalSlug   = $locale === 'fr' ? ($integrations['legal_page_slug_fr'] ?? 'mentions-legales') : ($integrations['legal_page_slug_en'] ?? 'legal-notice');
    $footerPrivacySlug = $locale === 'fr' ? ($integrations['privacy_page_slug_fr'] ?? 'politique-confidentialite') : ($integrations['privacy_page_slug_en'] ?? 'privacy-policy');
    ?>
    <footer>
        <div class="footer-area footer-bg">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-3 col-md-7">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?= esc(site_trans('footer_info_title', $locale)) ?></h4>
                                <div class="footer-info">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="icon"><i class="flaticon-pin"></i></div>
                                            <div class="content"><p><?= esc($contactAddress ?? '') ?></p></div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="flaticon-phone-call"></i></div>
                                            <div class="content">
                                                <a href="tel:<?= esc(preg_replace('/\s+/', '', (string) ($contactPhone1 ?? '')), 'attr') ?>"><?= esc($contactPhone1 ?? '') ?></a><br>
                                                <a href="tel:<?= esc(preg_replace('/\s+/', '', (string) ($contactPhone2 ?? '')), 'attr') ?>"><?= esc($contactPhone2 ?? '') ?></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="flaticon-clock"></i></div>
                                            <div class="content">
                                                <p><?= esc(site_trans('footer_opening_hours', $locale)) ?>, <br> <?= esc(site_trans('footer_sunday', $locale)) ?> : <span><?= esc(site_trans('footer_closed', $locale)) ?></span></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 col-sm-6">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?= esc(site_trans('footer_menu_title', $locale)) ?></h4>
                                <div class="footer-link">
                                    <ul class="list-wrap">
                                        <li><a href="<?= page_url('about', $locale) ?>"><?= esc(site_trans('footer_menu_company', $locale)) ?></a></li>
                                        <li><a href="#"><?= esc(site_trans('footer_menu_careers', $locale)) ?></a></li>
                                        <li><a href="<?= esc(site_url($locale . '/' . ltrim($footerLegalSlug, '/')), 'attr') ?>"><?= esc($locale === 'fr' ? 'Mentions légales' : 'Legal notice') ?></a></li>
                                        <li><a href="<?= page_url('blog', $locale) ?>"><?= esc(site_trans('nav_blog', $locale)) ?></a></li>
                                        <li><a href="<?= esc(site_url($locale . '/' . ltrim($footerPrivacySlug, '/')), 'attr') ?>"><?= esc(site_trans('footer_menu_privacy', $locale)) ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 col-sm-6">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?= esc(site_trans('footer_quicklinks_title', $locale)) ?></h4>
                                <div class="footer-link">
                                    <ul class="list-wrap">
                                        <li><a href="#"><?= esc(site_trans('footer_ql_how', $locale)) ?></a></li>
                                        <li><a href="#"><?= esc(site_trans('footer_ql_partners', $locale)) ?></a></li>
                                        <li><a href="#"><?= esc(site_trans('footer_ql_testimonials', $locale)) ?></a></li>
                                        <li><a href="<?= page_url('projects', $locale) ?>"><?= esc(site_trans('footer_ql_cases', $locale)) ?></a></li>
                                        <li><a href="#"><?= esc(site_trans('footer_ql_pricing', $locale)) ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?= esc(site_trans('footer_newsletter', $locale)) ?></h4>
                                <div class="footer-newsletter">
                                    <p><?= esc(site_trans('footer_newsletter_desc', $locale)) ?></p>
                                    <form id="newsletter-form" action="<?= site_url($locale . '/newsletter/subscribe') ?>" method="post" novalidate>
                                        <?= csrf_field() ?>
                                        <input type="text" name="company_website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">
                                        <input type="email" name="email" placeholder="<?= esc(site_trans('footer_email_placeholder', $locale)) ?>" required autocomplete="email">
                                        <button type="submit"><?= btn_icon('subscribe') ?><?= esc(site_trans('footer_subscribe', $locale)) ?></button>
                                    </form>
                                    <div class="newsletter-response ajax-response" role="status" aria-live="polite"></div>
                                    <span><?= esc(site_trans('footer_no_spam', $locale)) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="left-sider">
                                <div class="f-logo">
                                    <a href="<?= page_url('home', $locale) ?>"><img src="<?= esc($logoLight ?? asset_url('img/logo/w_logo02.png'), 'attr') ?>" alt=""></a>
                                </div>
                                <div class="copyright-text">
                                    <p><?= esc(site_trans('footer_copyright', $locale)) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="footer-social">
                                <?= social_icons_html($socialLinks ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/<?= esc($whatsappNumber ?? '', 'attr') ?>?text=<?= urlencode($whatsappMessage ?? '') ?>"
       class="whatsapp-float js-track-whatsapp"
       target="_blank"
       rel="noopener noreferrer"
       title="<?= esc(site_trans('whatsapp_text', $locale)) ?>"
       data-track="whatsapp_click"
       aria-label="<?= esc(site_trans('whatsapp_text', $locale)) ?>">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </a>

    <?= view('front/partials/tracking-config', compact('integrations', 'recaptchaSiteKey', 'recaptchaOn', 'locale')) ?>

    <script src="<?= asset_url('js/vendor/jquery-3.6.0.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/bootstrap.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jquery.magnific-popup.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jquery.odometer.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jquery.appear.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/gsap.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/ScrollTrigger.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/SplitText.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/gsap-animation.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jarallax.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jquery.parallaxScroll.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/particles.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jquery.easypiechart.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/jquery.inview.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/swiper-bundle.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/slick.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= esc(asset_url('js/ajax-form.js', true), 'attr') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= esc(asset_url('js/recaptcha-forms.js', true), 'attr') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= esc(asset_url('js/aos.js', true), 'attr') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= asset_url('js/wow.min.js') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= esc(asset_url('js/site-consent.js', true), 'attr') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= esc(asset_url('js/site-tracking.js', true), 'attr') ?>"<?= $scriptDefer ?>></script>
    <script src="<?= esc(asset_url('js/main.js', true), 'attr') ?>"<?= $scriptDefer ?>></script>
    <script>
        const text = document.querySelector('.circle');
        if (text) {
            text.innerHTML = text.textContent.replace(/\S/g, "<span>$&</span>");
            const element = document.querySelectorAll('.circle span');
            for (let i = 0; i < element.length; i++) {
                element[i].style.transform = "rotate(" + i * 16 + "deg)";
            }
        }
    </script>
    <script>
    document.getElementById('newsletter-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const responseEl = form.parentElement.querySelector('.newsletter-response');
        const data = new FormData(form);
        try {
            const res = await fetch(form.action, { method: 'POST', body: data, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
            const json = await res.json();
            if (responseEl) {
                responseEl.textContent = json.message || '';
                responseEl.className = 'newsletter-response ajax-response ' + (json.success ? 'text-success' : 'text-danger');
            }
            if (json.success) form.reset();
        } catch (err) {
            if (responseEl) responseEl.textContent = 'Error';
        }
    });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
