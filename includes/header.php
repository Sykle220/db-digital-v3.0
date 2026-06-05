<?php
// includes/header.php
$is_home = basename($_SERVER['PHP_SELF']) === 'index.php';
$header_class = $is_home ? 'transparent-header' : 'header-style-six';
$menu_class = $is_home ? 'menu-area menu-area-six' : 'menu-area';
$logo_img = $is_home ? 'w_logo02.png' : 'logo.png';
?>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="loading-center">
            <div class="loader"><div class="loader-outter"></div><div class="loader-inner"></div></div>
        </div>
    </div>

    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html"><i class="fas fa-angle-up"></i></button>

    <!-- Header -->
    <?php if (!$is_home): ?><div id="header-fixed-height"></div><?php endif; ?>
    
    <header class="<?php echo $header_class; ?>">
        <!-- Top Bar -->
        <div class="heder-top-wrap">
            <div class="container custom-container-seven">
                <div class="row align-items-center">
                    <div class="col-12 col-md-7">
                        <div class="header-top-left">
                            <ul class="list-wrap">
                                <li class="d-none d-md-flex"><i class="flaticon-location"></i><?php echo CONTACT_ADDRESS; ?></li>
                                <li class="d-none d-lg-flex"><i class="flaticon-mail"></i><a href="mailto:<?php echo CONTACT_EMAIL; ?>"><?php echo CONTACT_EMAIL; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="header-top-right">
                            <div class="header-contact">
                                <a href="tel:<?php echo preg_replace('/\s+/', '', CONTACT_PHONE_1); ?>">
                                    <i class="flaticon-phone-call"></i><?php echo CONTACT_PHONE_1; ?>
                                </a>
                            </div>
                            <div class="header-social">
                                <?php echo renderSocialIcons(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div id="sticky-header" class="<?php echo $menu_class; ?>">
            <div class="container<?php echo $is_home ? ' custom-container-seven' : ''; ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="menu-wrap">
                            <nav class="menu-nav">
                                <div class="logo">
                                    <a href="index.php<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>">
                                        <img src="<?php echo ASSETS_URL; ?>img/logo/<?php echo $logo_img; ?>" alt="Logo">
                                    </a>
                                </div>
                                <div class="navbar-wrap main-menu d-none d-lg-flex">
                                    <ul class="navigation">
                                        <?php foreach ($nav_items as $item): ?>
                                            <li class="<?php echo isActive($item['url']) . ' ' . $item['class']; ?>">
                                                <a href="<?php echo $item['url'] . ($current_lang !== 'en' ? '?lang=' . $current_lang : ''); ?>">
                                                    <?php echo __($item['label_key'] ?? 'nav_' . strtolower(str_replace([' ', 'Us'], ['_', ''], $item['label']))); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="header-nav-right">
                                    <div class="header-action<?php echo $is_home ? ' header-action-six' : ''; ?>">
                                        <ul class="list-wrap">
                                            <li class="header-search d-none d-lg-block"><a href="#"><i class="flaticon-search"></i></a></li>
                                            <li class="header-btn<?php echo $is_home ? '' : ' d-none d-lg-block'; ?>"><a href="get-quote.php<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>" class="btn btn-two btn-has-i"><?php echo btnIcon('quote'); ?><?php echo __('btn_quote'); ?></a></li>
                                            <li class="header-lang d-none d-lg-block">
                                                <div class="lang-switcher">
                                                    <a href="<?php echo getLangUrl('', 'fr'); ?>" class="lang-fr <?php echo $current_lang === 'fr' ? 'active' : ''; ?>" title="Français">FR</a>
                                                    <a href="<?php echo getLangUrl('', 'en'); ?>" class="lang-en <?php echo $current_lang === 'en' ? 'active' : ''; ?>" title="English">EN</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                                </div>
                            </nav>
                        </div>

                        <!-- Mobile Menu -->
                        <div class="mobile-menu">
                            <nav class="menu-box">
                                <div class="close-btn"><i class="fas fa-times"></i></div>
                                <div class="nav-logo">
                                    <a href="index.php<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>">
                                        <img src="<?php echo ASSETS_URL; ?>img/logo/logo.png" alt="Logo">
                                    </a>
                                </div>
                                <div class="mobile-search">
                                    <form action="#"><input type="text" placeholder="<?php echo __('search_placeholder'); ?>"><button><i class="flaticon-search"></i></button></form>
                                </div>
                                <div class="menu-outer"></div>
                                <div class="header-action header-action-six">
                                    <ul class="list-wrap">
                                        <li class="header-btn"><a href="get-quote.php<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>" class="btn btn-two btn-has-i"><?php echo btnIcon('quote'); ?><?php echo __('btn_quote'); ?></a></li>
                                    </ul>
                                </div>
                                <!-- SWITCH LANGUE MOBILE -->
                                <div class="lang-switcher">
                                    <a href="<?php echo getLangUrl('', 'fr'); ?>" class="lang-fr <?php echo $current_lang === 'fr' ? 'active' : ''; ?>" title="Français">FR</a>
                                    <a href="<?php echo getLangUrl('', 'en'); ?>" class="lang-en <?php echo $current_lang === 'en' ? 'active' : ''; ?>" title="English">EN</a>
                                </div>
                                <div class="social-links">
                                    <?php echo renderSocialIcons('clearfix'); ?>
                                </div>
                            </nav>
                        </div>
                        <div class="menu-backdrop"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Popup -->
        <div class="search-popup-wrap" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="search-close"><span><i class="fas fa-times"></i></span></div>
            <div class="search-wrap text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="title">... <?php echo __('search_title'); ?> ...</h2>
                            <div class="search-form">
                                <form action="#"><input type="text" name="search" placeholder="<?php echo __('search_placeholder'); ?>"><button class="search-btn"><i class="fas fa-search"></i></button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>