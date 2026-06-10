<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    /** @var array<string, string> */
    private array $langFr = [];

    /** @var array<string, string> */
    private array $langEn = [];

    public function run(): void
    {
        if (! $this->db->tableExists('seo_meta')) {
            return;
        }

        helper(['url', 'site']);

        $this->langFr = require APPPATH . 'Language/fr/App.php';
        $this->langEn = require APPPATH . 'Language/en/App.php';

        $this->seedStaticPages();
        $this->seedCmsPages();
        $this->seedServices();
        $this->seedBlogPosts();
        $this->seedOffices();
    }

    protected function seedStaticPages(): void
    {
        $static = [
            'home' => [
                'fr' => [
                    'meta_title'       => 'Agence digitale au Cameroun',
                    'meta_description' => $this->t('fr', 'meta_default_description'),
                    'meta_keywords'    => 'agence digitale, cameroun, yaoundé, douala, stratégie digitale, marketing',
                    'canonical_url'    => page_url('home', 'fr'),
                ],
                'en' => [
                    'meta_title'       => 'Digital agency in Cameroon',
                    'meta_description' => $this->t('en', 'meta_default_description'),
                    'meta_keywords'    => 'digital agency, cameroon, yaounde, douala, digital strategy, marketing',
                    'canonical_url'    => page_url('home', 'en'),
                ],
            ],
            'contact' => [
                'fr' => [
                    'meta_title'       => $this->t('fr', 'contact_page_title'),
                    'meta_description' => $this->t('fr', 'contact_page_lead'),
                    'meta_keywords'    => 'contact agence digitale, devis, douala, yaoundé, bafoussam',
                    'canonical_url'    => page_url('contact', 'fr'),
                ],
                'en' => [
                    'meta_title'       => $this->t('en', 'contact_page_title'),
                    'meta_description' => $this->t('en', 'contact_page_lead'),
                    'meta_keywords'    => 'contact digital agency, quote, douala, yaounde, bafoussam',
                    'canonical_url'    => page_url('contact', 'en'),
                ],
            ],
            'quote' => [
                'fr' => [
                    'meta_title'       => $this->t('fr', 'quote_title'),
                    'meta_description' => $this->t('fr', 'quote_desc'),
                    'meta_keywords'    => 'devis site web, devis agence digitale, cameroun',
                    'canonical_url'    => page_url('get-quote', 'fr'),
                ],
                'en' => [
                    'meta_title'       => $this->t('en', 'quote_title'),
                    'meta_description' => $this->t('en', 'quote_desc'),
                    'meta_keywords'    => 'website quote, digital agency quote, cameroon',
                    'canonical_url'    => page_url('get-quote', 'en'),
                ],
            ],
            'blog' => [
                'fr' => [
                    'meta_title'       => $this->t('fr', 'blog_page_title'),
                    'meta_description' => $this->t('fr', 'blog_page_description'),
                    'meta_keywords'    => 'blog digital, seo, marketing cameroun, stratégie digitale',
                    'canonical_url'    => page_url('blog', 'fr'),
                ],
                'en' => [
                    'meta_title'       => $this->t('en', 'blog_page_title'),
                    'meta_description' => $this->t('en', 'blog_page_description'),
                    'meta_keywords'    => 'digital blog, seo, marketing cameroon, digital strategy',
                    'canonical_url'    => page_url('blog', 'en'),
                ],
            ],
            'project' => [
                'fr' => [
                    'meta_title'       => $this->t('fr', 'breadcrumb_projects'),
                    'meta_description' => $this->t('fr', 'projects_title'),
                    'meta_keywords'    => 'projets digitaux, portfolio, agence digitale cameroun',
                    'canonical_url'    => page_url('projects', 'fr'),
                ],
                'en' => [
                    'meta_title'       => $this->t('en', 'breadcrumb_projects'),
                    'meta_description' => $this->t('en', 'projects_title'),
                    'meta_keywords'    => 'digital projects, portfolio, digital agency cameroon',
                    'canonical_url'    => page_url('projects', 'en'),
                ],
            ],
            'services_index' => [
                'fr' => [
                    'meta_title'       => $this->t('fr', 'services_page_title'),
                    'meta_description' => $this->t('fr', 'services_page_lead'),
                    'meta_keywords'    => 'services digitaux, web, branding, marketing, cameroun',
                    'canonical_url'    => page_url('services', 'fr'),
                ],
                'en' => [
                    'meta_title'       => $this->t('en', 'services_page_title'),
                    'meta_description' => $this->t('en', 'services_page_lead'),
                    'meta_keywords'    => 'digital services, web, branding, marketing, cameroon',
                    'canonical_url'    => page_url('services', 'en'),
                ],
            ],
        ];

        foreach ($static as $type => $locales) {
            foreach ($locales as $locale => $data) {
                $this->upsertMeta($type, 1, $locale, $data);
            }
        }

        foreach (['fr', 'en'] as $locale) {
            $this->upsertMeta('page', 1, $locale, [
                'meta_title'       => $this->t($locale, 'about_page_title'),
                'meta_description' => $this->t($locale, 'about_page_desc'),
                'meta_keywords'    => $locale === 'fr'
                    ? 'à propos, agence digitale yaoundé, équipe, cameroun'
                    : 'about us, digital agency yaounde, team, cameroon',
                'canonical_url'    => page_url('about', $locale),
                'og_title'         => $this->t($locale, 'about_page_title'),
                'og_description'   => $this->t($locale, 'about_page_desc'),
            ]);
        }
    }

    protected function seedCmsPages(): void
    {
        if (! $this->db->tableExists('pages') || ! $this->db->tableExists('page_translations')) {
            return;
        }

        $rows = $this->db->table('pages p')
            ->select('p.id, p.template, pt.locale, pt.slug, pt.title, pt.excerpt, pt.content, pt.meta_title, pt.meta_description')
            ->join('page_translations pt', 'pt.page_id = p.id')
            ->where('p.template', 'legal')
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $locale   = (string) $row['locale'];
            $title    = (string) ($row['title'] ?? '');
            $slug     = (string) ($row['slug'] ?? '');
            $excerpt  = strip_tags((string) ($row['excerpt'] ?? ''));
            $content  = $this->excerpt(strip_tags((string) ($row['content'] ?? '')), 155);
            $description = $excerpt !== '' ? $this->excerpt($excerpt, 155) : $content;

            if ($description === '') {
                $description = $locale === 'fr'
                    ? 'Informations légales et politique de confidentialité de DB Digital Agency.'
                    : 'Legal information and privacy policy for DB Digital Agency.';
            }

            $this->upsertMeta('page', (int) $row['id'], $locale, [
                'meta_title'       => $title,
                'meta_description' => $description,
                'meta_keywords'    => $locale === 'fr'
                    ? 'mentions légales, confidentialité, rgpd, cameroun'
                    : 'legal notice, privacy, gdpr, cameroon',
                'canonical_url'    => site_url($locale . '/' . ltrim($slug, '/')),
                'robots'           => 'index,follow',
            ]);
        }
    }

    protected function seedServices(): void
    {
        if (! $this->db->tableExists('services') || ! $this->db->tableExists('service_translations')) {
            return;
        }

        $rows = $this->db->table('services s')
            ->select('s.id, s.slug, st.locale, st.title, st.description, st.intro')
            ->join('service_translations st', 'st.service_id = s.id')
            ->where('s.is_active', 1)
            ->orderBy('s.sort_order', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $locale      = (string) $row['locale'];
            $slug        = (string) ($row['slug'] ?? '');
            $title       = (string) ($row['title'] ?? '');
            $description = $this->excerpt((string) ($row['description'] ?? $row['intro'] ?? ''), 155);
            $keywords    = $this->serviceKeywords($slug, $title, $locale);

            $this->upsertMeta('service', (int) $row['id'], $locale, [
                'meta_title'       => $title,
                'meta_description' => $description,
                'meta_keywords'    => $keywords,
                'canonical_url'    => service_url($slug, $locale),
                'og_title'         => $title,
                'og_description'   => $description,
            ]);
        }
    }

    protected function seedBlogPosts(): void
    {
        if (! $this->db->tableExists('blog_posts') || ! $this->db->tableExists('blog_post_translations')) {
            return;
        }

        $rows = $this->db->table('blog_posts bp')
            ->select('bp.id, bp.slug, bpt.locale, bpt.title, bpt.excerpt')
            ->join('blog_post_translations bpt', 'bpt.post_id = bp.id')
            ->where('bp.is_published', 1)
            ->orderBy('bp.sort_order', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $locale      = (string) $row['locale'];
            $slug        = (string) ($row['slug'] ?? '');
            $title       = (string) ($row['title'] ?? '');
            $description = $this->excerpt((string) ($row['excerpt'] ?? ''), 155);

            $this->upsertMeta('blog_post', (int) $row['id'], $locale, [
                'meta_title'       => $title,
                'meta_description' => $description,
                'meta_keywords'    => $locale === 'fr'
                    ? 'blog digital, ' . mb_strtolower($title) . ', cameroun'
                    : 'digital blog, ' . mb_strtolower($title) . ', cameroon',
                'canonical_url'    => rtrim(page_url('blog', $locale), '/') . '/' . rawurlencode($slug),
                'og_title'         => $title,
                'og_description'   => $description,
            ]);
        }
    }

    protected function seedOffices(): void
    {
        if (! $this->db->tableExists('office_locations')) {
            return;
        }

        $offices = $this->db->table('office_locations')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();

        $cityNames = [
            'douala'     => ['fr' => 'Douala', 'en' => 'Douala'],
            'yaounde'    => ['fr' => 'Yaoundé', 'en' => 'Yaoundé'],
            'bafoussam'  => ['fr' => 'Bafoussam', 'en' => 'Bafoussam'],
        ];

        foreach ($offices as $office) {
            $id  = (int) ($office['id'] ?? 0);
            $key = (string) ($office['key'] ?? '');
            if ($key === '' && ! empty($office['email'])) {
                $key = (string) strstr((string) $office['email'], '@', true);
            }

            if ($id <= 0 || $key === '') {
                continue;
            }

            foreach (['fr', 'en'] as $locale) {
                $city = $cityNames[$key][$locale] ?? ucfirst($key);
                $title = $locale === 'fr'
                    ? 'Agence digitale à ' . $city
                    : 'Digital agency in ' . $city;
                $description = $locale === 'fr'
                    ? 'DB Digital Agency accompagne les entreprises à ' . $city . ' : stratégie digitale, web, branding, SEO et acquisition.'
                    : 'DB Digital Agency supports businesses in ' . $city . ' with digital strategy, web, branding, SEO and acquisition.';

                $this->upsertMeta('office', $id, $locale, [
                    'meta_title'       => $title,
                    'meta_description' => $description,
                    'meta_keywords'    => $locale === 'fr'
                        ? 'agence digitale ' . mb_strtolower($city) . ', seo local, web cameroun'
                        : 'digital agency ' . mb_strtolower($city) . ', local seo, web cameroon',
                    'canonical_url'    => city_url($key, $locale),
                    'og_title'         => $title,
                    'og_description'   => $description,
                ]);
            }
        }
    }

    /**
     * @param array<string, string|null> $data
     */
    protected function upsertMeta(string $entityType, int $entityId, string $locale, array $data): void
    {
        $payload = array_merge([
            'entity_type'      => $entityType,
            'entity_id'        => $entityId,
            'locale'           => $locale,
            'meta_title'       => '',
            'meta_description' => '',
            'meta_keywords'    => '',
            'og_title'         => $data['meta_title'] ?? '',
            'og_description'   => $data['meta_description'] ?? '',
            'og_image_id'      => null,
            'canonical_url'    => '',
            'robots'           => 'index,follow',
            'schema_json'      => null,
        ], $data);

        if (($payload['og_title'] ?? '') === '') {
            $payload['og_title'] = $payload['meta_title'];
        }
        if (($payload['og_description'] ?? '') === '') {
            $payload['og_description'] = $payload['meta_description'];
        }

        $existing = $this->db->table('seo_meta')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('locale', $locale)
            ->get()
            ->getRowArray();

        if ($existing) {
            $this->db->table('seo_meta')->where('id', $existing['id'])->update($payload);
        } else {
            $this->db->table('seo_meta')->insert($payload);
        }
    }

    protected function excerpt(string $text, int $max = 155): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', trim(strip_tags($text))) ?? '';

        if ($text === '') {
            return '';
        }

        if (mb_strlen($text) <= $max) {
            return $text;
        }

        $cut = mb_substr($text, 0, $max - 1);
        $lastSpace = mb_strrpos($cut, ' ');
        if ($lastSpace !== false && $lastSpace > (int) ($max * 0.6)) {
            $cut = mb_substr($cut, 0, $lastSpace);
        }

        return rtrim($cut, '.,;:!?') . '…';
    }

    protected function serviceKeywords(string $slug, string $title, string $locale): string
    {
        $base = $locale === 'fr'
            ? 'agence digitale, cameroun, yaoundé, douala'
            : 'digital agency, cameroon, yaounde, douala';

        $slugMap = [
            'digital-strategy' => $locale === 'fr'
                ? 'stratégie digitale, marketing, audit digital'
                : 'digital strategy, marketing, digital audit',
            'web-development' => $locale === 'fr'
                ? 'développement web, site internet, application'
                : 'web development, website, application',
            'branding' => $locale === 'fr'
                ? 'branding, identité visuelle, ui ux'
                : 'branding, visual identity, ui ux',
            'marketing' => $locale === 'fr'
                ? 'marketing digital, acquisition, publicité'
                : 'digital marketing, acquisition, advertising',
        ];

        $specific = $slugMap[$slug] ?? mb_strtolower($title);

        return $specific . ', ' . $base;
    }

    protected function t(string $locale, string $key): string
    {
        $lang = $locale === 'fr' ? $this->langFr : $this->langEn;

        return (string) ($lang[$key] ?? '');
    }
}
