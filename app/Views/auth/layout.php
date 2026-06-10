<?php
helper(['url', 'site']);

$branding   = service('branding');
$favicon    = $branding->getAdminFavicon() ?? $branding->getFavicon() ?? asset_url('img/favicon.png');
$brandLogo  = $branding->getAdminLogo() ?? $branding->getLogoLight() ?? $favicon;
$siteName   = (string) (service('siteSettings')->get('site_name') ?? env('SITE_NAME', 'DB Digital Agency'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> — <?= esc($siteName) ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= esc($favicon, 'attr') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= esc(asset_url('css/admin.css', true), 'attr') ?>">
    <?= $this->renderSection('pageStyles') ?>
</head>
<body class="auth-app">
    <div class="auth-shell">
        <aside class="auth-brand" aria-hidden="true">
            <div class="auth-brand__inner">
                <img src="<?= esc($brandLogo, 'attr') ?>" alt="" class="auth-brand__logo<?= $branding->getAdminLogo() !== null || $branding->getLogoLight() !== null ? ' auth-brand__logo--wide' : '' ?>">
                <h1 class="auth-brand__title"><?= esc($siteName) ?></h1>
                <p class="auth-brand__lead">Pilotez votre contenu, vos leads et votre présence digitale depuis un seul espace.</p>
                <ul class="auth-brand__features">
                    <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Gestion multilingue FR / EN</li>
                    <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Pages, blog & SEO</li>
                    <li><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Devis & contacts centralisés</li>
                </ul>
            </div>
        </aside>

        <main class="auth-main">
            <div class="auth-main__card">
                <?= $this->renderSection('main') ?>
            </div>
            <p class="auth-footer">
                <a href="<?= site_url('fr') ?>" target="_blank" rel="noopener">
                    <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                    Voir le site public
                </a>
            </p>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('pageScripts') ?>
</body>
</html>
