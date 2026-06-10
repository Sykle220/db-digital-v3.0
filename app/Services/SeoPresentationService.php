<?php

namespace App\Services;

/**
 * Construit les métadonnées SEO unifiées pour le layout front.
 */
class SeoPresentationService
{
    protected SeoService $seo;
    protected BrandingService $branding;

    public function __construct(?SeoService $seo = null, ?BrandingService $branding = null)
    {
        $this->seo       = $seo ?? service('seo');
        $this->branding  = $branding ?? service('branding');
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    public function build(array $options): array
    {
        $locale = (string) ($options['locale'] ?? service('request')->getLocale());
        $entityType = $options['entityType'] ?? null;
        $entityId   = isset($options['entityId']) ? (int) $options['entityId'] : 0;

        $dbMeta = ($entityType !== null && $entityId > 0)
            ? ($this->seo->getMeta($entityType, $entityId, $locale) ?? [])
            : [];

        $title       = (string) ($dbMeta['meta_title'] ?? $options['title'] ?? '');
        $description = (string) ($dbMeta['meta_description'] ?? $options['description'] ?? '');
        $robots      = (string) ($dbMeta['robots'] ?? $options['robots'] ?? '');
        $canonical   = (string) ($dbMeta['canonical_url'] ?? $options['canonical'] ?? current_url());

        $ogTitle       = (string) ($dbMeta['og_title'] ?? $options['ogTitle'] ?? $title);
        $ogDescription = (string) ($dbMeta['og_description'] ?? $options['ogDescription'] ?? $description);
        $ogType        = (string) ($options['ogType'] ?? 'website');
        $ogImage       = (string) ($dbMeta['og_image_url'] ?? $options['ogImage'] ?? $this->defaultOgImage());

        $siteName = (string) ($options['siteName'] ?? 'DB Digital Agency');
        $suffix   = site_trans('meta_suffix', $locale);

        if ($title === '') {
            $title = $suffix;
        }

        $fullTitle = str_contains($title, $suffix) ? $title : trim($title . ' - ' . $suffix);
        $seoIndex  = $options['seoIndex'] ?? true;
        if ($robots === '') {
            $robots = $seoIndex ? 'index,follow' : 'noindex,nofollow';
        }

        $schemas = $options['schemas'] ?? [];
        if (! empty($dbMeta['schema_json'])) {
            $decoded = json_decode((string) $dbMeta['schema_json'], true);
            if (is_array($decoded)) {
                $schemas[] = $decoded;
            }
        }

        return [
            'title'           => $title,
            'fullTitle'       => $fullTitle,
            'description'     => $description,
            'canonical'       => $canonical,
            'robots'          => $robots,
            'ogTitle'         => $ogTitle !== '' ? $ogTitle : $fullTitle,
            'ogDescription'   => $ogDescription,
            'ogImage'         => $ogImage,
            'ogType'          => $ogType,
            'ogLocale'        => $locale === 'fr' ? 'fr_FR' : 'en_US',
            'twitterCard'     => 'summary_large_image',
            'schemas'         => $schemas,
        ];
    }

    protected function defaultOgImage(): string
    {
        $branding = $this->branding->getBranding();

        return (string) ($branding['og_default_image'] ?? $branding['logo_dark'] ?? asset_url('img/logo/logo.png'));
    }
}
