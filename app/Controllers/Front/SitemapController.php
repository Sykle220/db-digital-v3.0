<?php

namespace App\Controllers\Front;

class SitemapController extends BaseFrontController
{
    public function index()
    {
        $settings = service('siteSettings');
        if ($settings->get('sitemap_enabled', '1') === '0') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $content  = service('content');
        $baseUrl  = rtrim((string) (env('APP_URL') ?: config('App')->baseURL), '/');
        $services = $content->getServices();
        $posts    = $content->getBlogPosts();
        $offices  = $content->getOffices();
        $locales  = config('App')->supportedLocales ?: ['fr', 'en'];
        $changefreq = $settings->get('sitemap_changefreq', 'weekly');
        $priority   = $settings->get('sitemap_priority', '0.8');

        $urls = [];

        foreach ($locales as $locale) {
            $urls[] = ['loc' => $baseUrl . '/' . $locale, 'changefreq' => 'weekly', 'priority' => '1.0'];
            $urls[] = ['loc' => page_url('about', $locale), 'changefreq' => 'monthly', 'priority' => '0.7'];
            $urls[] = ['loc' => page_url('services', $locale), 'changefreq' => 'monthly', 'priority' => '0.9'];
            $urls[] = ['loc' => page_url('projects', $locale), 'changefreq' => 'monthly', 'priority' => '0.8'];
            $urls[] = ['loc' => page_url('blog', $locale), 'changefreq' => 'weekly', 'priority' => '0.7'];
            $urls[] = ['loc' => page_url('contact', $locale), 'changefreq' => 'monthly', 'priority' => '0.6'];
            $urls[] = ['loc' => page_url('get-quote', $locale), 'changefreq' => 'monthly', 'priority' => '0.6'];

            foreach ($services as $service) {
                $slug = (string) ($service['slug'] ?? '');
                if ($slug !== '') {
                    $urls[] = ['loc' => service_url($slug, $locale), 'changefreq' => 'monthly', 'priority' => '0.8'];
                }
            }

            foreach ($posts as $post) {
                $slug = (string) ($post['slug'] ?? '');
                if ($slug !== '') {
                    $urls[] = ['loc' => page_url('blog', $locale) . '/' . rawurlencode($slug), 'changefreq' => 'monthly', 'priority' => '0.6'];
                }
            }

            $cityPrefix = $locale === 'fr' ? 'agence-digitale' : 'digital-agency';
            foreach ($offices as $office) {
                $key = (string) ($office['key'] ?? '');
                if ($key !== '') {
                    $urls[] = [
                        'loc'        => site_url($locale . '/' . $cityPrefix . '/' . $key),
                        'changefreq' => $changefreq,
                        'priority'   => '0.75',
                    ];
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . esc($url['loc'], 'url') . '</loc>' . "\n";
            $xml .= '    <changefreq>' . esc($url['changefreq']) . '</changefreq>' . "\n";
            $xml .= '    <priority>' . esc($url['priority']) . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->setBody($xml);
    }
}
