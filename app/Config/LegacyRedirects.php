<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Redirections 301 des URLs legacy (phase 5) vers les routes CI4.
 *
 * @phpstan-type RedirectMap array<string, string>
 */
class LegacyRedirects extends BaseConfig
{
    /**
     * Chemin source (normalisé, avec slash initial) => chemin destination.
     *
     * @var RedirectMap
     */
    public array $map = [
        '/index.php'                              => '/fr',
        '/about.php'                              => '/fr/a-propos',
        '/services.php'                           => '/fr/services',
        '/services-details.php'                   => '/fr/services',
        '/projects.php'                           => '/fr/projets',
        '/blog.php'                               => '/fr/blog',
        '/contact.php'                            => '/fr/contact',
        '/get-quote.php'                          => '/fr/devis',
        '/sitemap.php'                            => '/sitemap.xml',
        '/includes/process-contact.php'           => '/fr/contact/submit',
        '/includes/process-quote.php'             => '/fr/devis/submit',
        '/includes/process-newsletter.php'        => '/fr/newsletter/subscribe',
    ];
}
