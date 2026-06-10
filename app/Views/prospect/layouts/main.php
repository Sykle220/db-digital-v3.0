<?php
helper(['url', 'site']);

$locale    = service('request')->getLocale();
$branding  = service('branding');
$logoDark  = $branding->getLogoDark() ?? asset_url('img/logo/logo.png');
$favicon   = $branding->getFavicon() ?? asset_url('img/favicon.png');
$siteName  = (string) (service('siteSettings')->get('site_name') ?? env('SITE_NAME', 'DB Digital Agency'));
?>
<!DOCTYPE html>
<html lang="<?= esc($locale) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? $siteName) ?> — <?= esc($siteName) ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= esc($favicon, 'attr') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= esc(asset_url('css/prospect.css', true), 'attr') ?>">
    <?= $this->renderSection('pageStyles') ?>
</head>
<body class="prospect-portal">
    <header class="prospect-portal__header">
        <div class="container prospect-portal__header-inner">
            <a href="<?= esc(page_url('home', $locale), 'attr') ?>" class="prospect-portal__logo">
                <img src="<?= esc($logoDark, 'attr') ?>" alt="<?= esc($siteName) ?>" height="40">
            </a>
            <div class="prospect-portal__header-actions">
                <span class="prospect-portal__badge">
                    <i class="bi bi-shield-check" aria-hidden="true"></i>
                    <?= esc(site_trans('prospect_portal_label', $locale)) ?>
                </span>
                <a href="<?= site_url('prospect/logout') ?>" class="prospect-portal__logout" title="<?= esc(site_trans('header_prospect_logout', $locale)) ?>">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline"><?= esc(site_trans('header_prospect_logout', $locale)) ?></span>
                </a>
            </div>
        </div>
    </header>

    <main class="prospect-portal__main">
        <div class="container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="prospect-alert prospect-alert--success" role="alert">
                    <i class="bi bi-check-circle" aria-hidden="true"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="prospect-alert prospect-alert--error" role="alert">
                    <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer class="prospect-portal__footer">
        <div class="container">
            <a href="<?= esc(page_url('home', $locale), 'attr') ?>">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                <?= esc(site_trans('prospect_back_site', $locale)) ?>
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('pageScripts') ?>
</body>
</html>
