<?php
helper(['url', 'site']);

$locale   = service('request')->getLocale();
$branding = service('branding');
$favicon   = $branding->getFavicon() ?? asset_url('img/favicon.png');
$logoLight = $branding->getLogoLight() ?? $favicon;
$siteName = (string) (service('siteSettings')->get('site_name') ?? env('SITE_NAME', 'DB Digital Agency'));
?>
<!DOCTYPE html>
<html lang="<?= esc($locale) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> — <?= esc($siteName) ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= esc($favicon, 'attr') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= esc(asset_url('css/admin.css', true), 'attr') ?>">
    <link rel="stylesheet" href="<?= esc(asset_url('css/prospect.css', true), 'attr') ?>">
    <?= $this->renderSection('pageStyles') ?>
</head>
<body class="auth-app">
    <div class="auth-shell">
        <aside class="auth-brand" aria-hidden="true">
            <div class="auth-brand__inner">
                <img src="<?= esc($logoLight, 'attr') ?>" alt="" class="auth-brand__logo auth-brand__logo--wide">
                <h1 class="auth-brand__title"><?= esc(site_trans('prospect_portal_label', $locale)) ?></h1>
                <p class="auth-brand__lead"><?= esc(site_trans('prospect_auth_lead', $locale)) ?></p>
                <ul class="auth-brand__features">
                    <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?= esc(site_trans('prospect_auth_feature_1', $locale)) ?></li>
                    <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?= esc(site_trans('prospect_auth_feature_2', $locale)) ?></li>
                    <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?= esc(site_trans('prospect_auth_feature_3', $locale)) ?></li>
                </ul>
            </div>
        </aside>

        <main class="auth-main">
            <div class="auth-main__card">
                <?= $this->renderSection('main') ?>
            </div>
            <p class="auth-footer">
                <a href="<?= esc(page_url('home', $locale), 'attr') ?>">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    <?= esc(site_trans('prospect_back_site', $locale)) ?>
                </a>
            </p>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('pageScripts') ?>
</body>
</html>
