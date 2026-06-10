<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Locale : regex explicite (évite que /brand, /admin, etc. soient traités comme locale)
$routes->addPlaceholder('locale', '(?:fr|en)');

// Default locale redirect
$routes->get('/', static function () {
    return redirect()->to('/fr');
});

// Sitemap
$routes->get('sitemap.xml', 'Front\SitemapController::index');

// Shield auth routes
service('auth')->routes($routes);

// Espace prospect — connexion par lien magique (e-mail du devis)
$routes->group('user', ['namespace' => 'App\Controllers\Prospect'], static function ($routes) {
    $routes->get('login', 'AccessController::index');
    $routes->post('login', 'AccessController::requestLink');
});

// Prospect panel (accès token + rétrocompatibilité)
$routes->group('prospect', ['namespace' => 'App\Controllers\Prospect'], static function ($routes) {
    $routes->get('access/(:segment)', 'AccessController::access/$1');
    $routes->get('access', static fn () => redirect()->to(site_url('user/login')));
    $routes->post('resend', 'AccessController::requestLink');
});

$routes->group('prospect', ['filter' => 'prospect', 'namespace' => 'App\Controllers\Prospect'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('brief', 'DashboardController::downloadBrief');
    $routes->post('upload', 'DashboardController::uploadDocument');
    $routes->get('logout', 'DashboardController::logout');
});

// Administration (avant les routes {locale})
$routes->group('admin', ['filter' => ['admin', 'csrf'], 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');

    $routes->get('pages', 'PagesController::index');
    $routes->get('pages/create', 'PagesController::create');
    $routes->post('pages', 'PagesController::store');
    $routes->get('pages/(:num)/edit', 'PagesController::edit/$1');
    $routes->match(['POST', 'PUT'], 'pages/(:num)', 'PagesController::update/$1');
    $routes->post('pages/(:num)/delete', 'PagesController::delete/$1');

    $routes->get('services', 'ServicesController::index');
    $routes->get('services/create', 'ServicesController::create');
    $routes->post('services', 'ServicesController::store');
    $routes->get('services/(:num)/edit', 'ServicesController::edit/$1');
    $routes->match(['POST', 'PUT'], 'services/(:num)', 'ServicesController::update/$1');
    $routes->post('services/(:num)/delete', 'ServicesController::delete/$1');

    $routes->get('blog', 'BlogController::index');
    $routes->get('blog/create', 'BlogController::create');
    $routes->post('blog', 'BlogController::store');
    $routes->get('blog/(:num)/edit', 'BlogController::edit/$1');
    $routes->match(['POST', 'PUT'], 'blog/(:num)', 'BlogController::update/$1');
    $routes->post('blog/(:num)/delete', 'BlogController::delete/$1');

    $routes->get('projects', 'ProjectsController::index');
    $routes->get('projects/create', 'ProjectsController::create');
    $routes->post('projects', 'ProjectsController::store');
    $routes->get('projects/(:num)/edit', 'ProjectsController::edit/$1');
    $routes->match(['POST', 'PUT'], 'projects/(:num)', 'ProjectsController::update/$1');
    $routes->post('projects/(:num)/delete', 'ProjectsController::delete/$1');

    $routes->get('team', 'TeamController::index');
    $routes->get('team/create', 'TeamController::create');
    $routes->post('team', 'TeamController::store');
    $routes->get('team/(:num)/edit', 'TeamController::edit/$1');
    $routes->match(['POST', 'PUT'], 'team/(:num)', 'TeamController::update/$1');
    $routes->post('team/(:num)/delete', 'TeamController::delete/$1');

    $routes->get('testimonials', 'TestimonialsController::index');
    $routes->get('testimonials/create', 'TestimonialsController::create');
    $routes->post('testimonials', 'TestimonialsController::store');
    $routes->get('testimonials/(:num)/edit', 'TestimonialsController::edit/$1');
    $routes->match(['POST', 'PUT'], 'testimonials/(:num)', 'TestimonialsController::update/$1');
    $routes->post('testimonials/(:num)/delete', 'TestimonialsController::delete/$1');

    $routes->get('brand-logos', 'BrandLogosController::index');
    $routes->get('brand-logos/create', 'BrandLogosController::create');
    $routes->post('brand-logos', 'BrandLogosController::store');
    $routes->get('brand-logos/(:num)/edit', 'BrandLogosController::edit/$1');
    $routes->match(['POST', 'PUT'], 'brand-logos/(:num)', 'BrandLogosController::update/$1');
    $routes->post('brand-logos/(:num)/delete', 'BrandLogosController::delete/$1');

    $routes->get('offices', 'OfficesController::index');
    $routes->get('offices/create', 'OfficesController::create');
    $routes->post('offices', 'OfficesController::store');
    $routes->get('offices/(:num)/edit', 'OfficesController::edit/$1');
    $routes->match(['POST', 'PUT'], 'offices/(:num)', 'OfficesController::update/$1');
    $routes->post('offices/(:num)/delete', 'OfficesController::delete/$1');

    $routes->get('homepage', 'HomepageController::index');
    $routes->match(['POST', 'PUT'], 'homepage', 'HomepageController::update');

    $routes->get('menus', 'MenusController::index');
    $routes->get('menus/create', 'MenusController::create');
    $routes->post('menus', 'MenusController::store');
    $routes->get('menus/(:num)/edit', 'MenusController::edit/$1');
    $routes->match(['POST', 'PUT'], 'menus/(:num)', 'MenusController::update/$1');
    $routes->post('menus/(:num)/delete', 'MenusController::delete/$1');

    $routes->get('media', 'MediaController::index');
    $routes->post('media', 'MediaController::store');
    $routes->get('media/picker', 'MediaController::picker');
    $routes->post('media/(:num)/delete', 'MediaController::delete/$1');

    $routes->get('translations', 'TranslationsController::index');
    $routes->post('translations/save', 'TranslationsController::save');

    $routes->get('branding', 'BrandingController::index');
    $routes->match(['POST', 'PUT'], 'branding', 'BrandingController::update');

    $routes->get('seo', 'SeoController::index');
    $routes->get('seo/meta', 'SeoController::meta');
    $routes->post('seo/meta', 'SeoController::saveMeta');
    $routes->get('seo/redirects/create', 'SeoController::createRedirect');
    $routes->post('seo/redirects', 'SeoController::storeRedirect');
    $routes->get('seo/redirects/(:num)/edit', 'SeoController::editRedirect/$1');
    $routes->match(['POST', 'PUT'], 'seo/redirects/(:num)', 'SeoController::updateRedirect/$1');
    $routes->post('seo/redirects/(:num)/delete', 'SeoController::deleteRedirect/$1');
    $routes->post('seo/sitemap', 'SeoController::saveSitemap');

    $routes->get('quotes', 'QuotesController::index');
    $routes->get('quotes/(:num)', 'QuotesController::show/$1');
    $routes->match(['POST', 'PUT'], 'quotes/(:num)', 'QuotesController::update/$1');
    $routes->post('quotes/(:num)/resend-magic-link', 'QuotesController::resendMagicLink/$1');

    $routes->get('contacts', 'ContactsController::index');
    $routes->get('contacts/(:num)', 'ContactsController::show/$1');
    $routes->match(['POST', 'PUT'], 'contacts/(:num)', 'ContactsController::update/$1');

    $routes->get('newsletter', 'NewsletterController::index');
    $routes->get('newsletter/export', 'NewsletterController::export');

    $routes->get('settings', 'SettingsController::index');
    $routes->match(['POST', 'PUT'], 'settings', 'SettingsController::update');

    $routes->get('integrations', 'IntegrationsController::index');
    $routes->match(['POST', 'PUT'], 'integrations', 'IntegrationsController::update');

    $routes->get('profile', 'ProfileController::index');
    $routes->match(['POST', 'PUT'], 'profile', 'ProfileController::update');
    $routes->post('profile/password', 'ProfileController::changePassword');

    $routes->get('users', 'UsersController::index');
    $routes->get('users/create', 'UsersController::create');
    $routes->post('users', 'UsersController::store');
    $routes->get('users/(:num)/edit', 'UsersController::edit/$1');
    $routes->match(['POST', 'PUT'], 'users/(:num)', 'UsersController::update/$1');
    $routes->post('users/(:num)/delete', 'UsersController::delete/$1');
});

// Routes public localisées (fr|en uniquement — pas de placeholder {locale} seul)
$registerLocaleRoutes = static function ($routes): void {
    $routes->get('/', 'HomeController::index');
    $routes->get('about', 'AboutController::index');
    $routes->get('a-propos', 'AboutController::index');

    $routes->get('services', 'ServicesController::index');
    $routes->get('services/(:segment)', 'ServicesController::detail/$1');

    $routes->get('agence-digitale/(:segment)', 'CityController::show/$1');
    $routes->get('digital-agency/(:segment)', 'CityController::show/$1');

    $routes->get('projects', 'ProjectsController::index');
    $routes->get('projets', 'ProjectsController::index');

    $routes->get('blog', 'BlogController::index');
    $routes->get('blog/(:segment)', 'BlogController::show/$1');

    $routes->get('contact', 'ContactController::index');
    $routes->post('contact/submit', 'ContactController::submit');

    $routes->get('devis', 'QuoteController::index');
    $routes->get('get-quote', 'QuoteController::index');
    $routes->post('devis/submit', 'QuoteController::submit');
    $routes->post('get-quote/submit', 'QuoteController::submit');
    $routes->get('devis/success', 'QuoteController::success');
    $routes->get('get-quote/success', 'QuoteController::success');

    $routes->post('newsletter/subscribe', 'NewsletterController::subscribe');

    // CMS dynamic pages (must be last)
    $routes->get('(:segment)', 'PageController::show/$1');
};

foreach (['fr', 'en'] as $localeCode) {
    $routes->group($localeCode, [
        'filter'    => 'siteLocale',
        'namespace' => 'App\Controllers\Front',
    ], $registerLocaleRoutes);
}

// Toute URL sans route définie (ex. /brand, /foo/bar) → page 404 applicative
$routes->get('(:any)', [\App\Controllers\Front\ErrorsController::class, 'show404']);

$routes->set404Override([\App\Controllers\Front\ErrorsController::class, 'show404']);
