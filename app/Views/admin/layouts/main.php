<?php
$brandingSvc  = service('branding');
$siteName     = (string) (service('siteSettings')->get('site_name') ?? env('SITE_NAME', 'DB Digital Agency'));
$adminLogoUrl = $brandingSvc->getAdminLogo();
$adminFavicon = $brandingSvc->getAdminFavicon() ?? $brandingSvc->getFavicon() ?? asset_url('img/favicon.png');
$sidebarLogo  = $adminLogoUrl ?? $adminFavicon;
$sidebarWide  = $adminLogoUrl !== null;
$userName     = (string) ($currentUser->username ?? 'Admin');
$userEmail    = (string) ($currentUser->email ?? '');
$userInitial  = strtoupper(mb_substr($userName, 0, 1));
$isSuperAdmin = (bool) ($isSuperAdmin ?? false);

$userGroups = [];
if ($currentUser !== null && method_exists($currentUser, 'getGroups')) {
    $userGroups = $currentUser->getGroups();
}
$userRoleLabel = match (true) {
    in_array('superadmin', $userGroups, true) => 'Super-admin',
    in_array('admin', $userGroups, true)      => 'Administrateur',
    in_array('editor', $userGroups, true)     => 'Éditeur',
    in_array('developer', $userGroups, true)  => 'Développeur',
    default                                   => 'Utilisateur',
};

$menuSections = [
    'Principal' => [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'url' => 'admin', 'icon' => 'bi-speedometer2'],
    ],
    'Contenu' => [
        ['key' => 'pages', 'label' => 'Pages', 'url' => 'admin/pages', 'icon' => 'bi-file-earmark-text'],
        ['key' => 'services', 'label' => 'Services', 'url' => 'admin/services', 'icon' => 'bi-briefcase'],
        ['key' => 'blog', 'label' => 'Blog', 'url' => 'admin/blog', 'icon' => 'bi-journal-richtext'],
        ['key' => 'projects', 'label' => 'Projets', 'url' => 'admin/projects', 'icon' => 'bi-folder2-open'],
        ['key' => 'team', 'label' => 'Équipe', 'url' => 'admin/team', 'icon' => 'bi-people'],
        ['key' => 'testimonials', 'label' => 'Témoignages', 'url' => 'admin/testimonials', 'icon' => 'bi-chat-quote'],
        ['key' => 'brand-logos', 'label' => 'Logos partenaires', 'url' => 'admin/brand-logos', 'icon' => 'bi-building'],
        ['key' => 'offices', 'label' => 'Bureaux', 'url' => 'admin/offices', 'icon' => 'bi-geo-alt'],
        ['key' => 'homepage', 'label' => "Page d'accueil", 'url' => 'admin/homepage', 'icon' => 'bi-house-door'],
    ],
    'Apparence' => [
        ['key' => 'menus', 'label' => 'Menus', 'url' => 'admin/menus', 'icon' => 'bi-list-ul'],
        ['key' => 'media', 'label' => 'Médias', 'url' => 'admin/media', 'icon' => 'bi-images'],
        ['key' => 'branding', 'label' => 'Branding', 'url' => 'admin/branding', 'icon' => 'bi-palette'],
        ['key' => 'translations', 'label' => 'Traductions', 'url' => 'admin/translations', 'icon' => 'bi-translate'],
    ],
    'Leads' => [
        ['key' => 'quotes', 'label' => 'Devis', 'url' => 'admin/quotes', 'icon' => 'bi-file-earmark-medical'],
        ['key' => 'contacts', 'label' => 'Contacts', 'url' => 'admin/contacts', 'icon' => 'bi-envelope'],
        ['key' => 'newsletter', 'label' => 'Newsletter', 'url' => 'admin/newsletter', 'icon' => 'bi-megaphone'],
    ],
    'SEO' => [
        ['key' => 'seo', 'label' => 'SEO & Redirections', 'url' => 'admin/seo', 'icon' => 'bi-search'],
    ],
    'Système' => array_values(array_filter([
        ['key' => 'settings', 'label' => 'Paramètres', 'url' => 'admin/settings', 'icon' => 'bi-gear'],
        ['key' => 'integrations', 'label' => 'Intégrations', 'url' => 'admin/integrations', 'icon' => 'bi-plug'],
        $isSuperAdmin
            ? ['key' => 'users', 'label' => 'Utilisateurs', 'url' => 'admin/users', 'icon' => 'bi-person-badge']
            : null,
    ])),
];

$menuSections = array_filter(
    $menuSections,
    static fn (array $items): bool => $items !== [],
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Administration') ?> — <?= esc($siteName) ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= esc($adminFavicon, 'attr') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= esc(asset_url('css/admin.css', true), 'attr') ?>">
</head>
<body class="admin-app">
    <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" aria-hidden="true"></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigation administration">
        <div class="admin-sidebar__brand">
            <a href="<?= site_url('admin') ?>" class="admin-sidebar__brand-link<?= $sidebarWide ? ' admin-sidebar__brand-link--wide' : '' ?>">
                <img
                    src="<?= esc($sidebarLogo, 'attr') ?>"
                    alt="<?= esc($siteName) ?>"
                    class="admin-sidebar__logo<?= $sidebarWide ? ' admin-sidebar__logo--wide' : '' ?>"
                    <?= $sidebarWide ? '' : 'width="42" height="42"' ?>
                >
                <?php if (! $sidebarWide): ?>
                <span>
                    <span class="admin-sidebar__title"><?= esc(mb_strlen($siteName) > 18 ? 'DB Digital' : $siteName) ?></span>
                    <span class="admin-sidebar__subtitle">Administration</span>
                </span>
                <?php endif; ?>
            </a>
        </div>

        <nav class="admin-sidebar__nav">
            <?php foreach ($menuSections as $groupLabel => $items): ?>
                <div class="admin-sidebar__group"><?= esc($groupLabel) ?></div>
                <?php foreach ($items as $item): ?>
                    <a
                        href="<?= site_url($item['url']) ?>"
                        class="admin-sidebar__link<?= ($activeMenu ?? '') === $item['key'] ? ' is-active' : '' ?>"
                    >
                        <i class="bi <?= esc($item['icon'], 'attr') ?>" aria-hidden="true"></i>
                        <?= esc($item['label']) ?>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>

        <div class="admin-sidebar__footer">
            <a class="admin-sidebar__link admin-sidebar__link--muted" href="<?= site_url('fr') ?>" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                Voir le site
            </a>
            <a class="admin-sidebar__link admin-sidebar__link--danger" href="<?= url_to('logout') ?>">
                <i class="bi bi-box-arrow-left" aria-hidden="true"></i>
                Déconnexion
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Ouvrir le menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1 class="admin-topbar__title"><?= esc($pageTitle ?? 'Administration') ?></h1>
                    <div class="admin-topbar__breadcrumb"><?= esc($siteName) ?> · CMS</div>
                </div>
            </div>
            <div class="dropdown">
                <button
                    type="button"
                    class="admin-user-chip admin-user-chip--toggle dropdown-toggle"
                    id="adminUserMenu"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="true"
                    aria-expanded="false"
                    aria-label="Menu utilisateur"
                >
                    <span class="admin-user-chip__avatar" aria-hidden="true"><?= esc($userInitial) ?></span>
                    <span class="admin-user-chip__name"><?= esc($userName) ?></span>
                    <i class="bi bi-chevron-down admin-user-chip__chevron" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end admin-user-menu" aria-labelledby="adminUserMenu">
                    <li class="admin-user-menu__head">
                        <p class="admin-user-menu__name"><?= esc($userName) ?></p>
                        <?php if ($userEmail !== ''): ?>
                            <p class="admin-user-menu__email"><?= esc($userEmail) ?></p>
                        <?php endif; ?>
                        <span class="admin-user-menu__role"><?= esc($userRoleLabel) ?></span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?= site_url('admin/profile') ?>">
                            <i class="bi bi-person-circle" aria-hidden="true"></i>
                            Mon profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= site_url('admin/settings') ?>">
                            <i class="bi bi-gear" aria-hidden="true"></i>
                            Paramètres
                        </a>
                    </li>
                    <?php if ($isSuperAdmin): ?>
                    <li>
                        <a class="dropdown-item" href="<?= site_url('admin/users') ?>">
                            <i class="bi bi-people" aria-hidden="true"></i>
                            Utilisateurs
                        </a>
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= url_to('logout') ?>">
                            <i class="bi bi-box-arrow-left" aria-hidden="true"></i>
                            Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </header>

        <main class="admin-content">
            <?= view('admin/components/flash') ?>
            <?= $content ?? '' ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('adminSidebarBackdrop');
        const toggle = document.getElementById('adminMenuToggle');
        if (!sidebar || !backdrop || !toggle) return;

        function openMenu() {
            sidebar.classList.add('is-open');
            backdrop.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            sidebar.classList.remove('is-open');
            backdrop.classList.remove('is-visible');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', function () {
            sidebar.classList.contains('is-open') ? closeMenu() : openMenu();
        });
        backdrop.addEventListener('click', closeMenu);
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) closeMenu();
        });
    })();
    </script>
</body>
</html>
