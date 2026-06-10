<?php

namespace App\Database\Seeds;

/**
 * Charge includes/config.php et expose les variables legacy.
 */
trait LegacyConfigTrait
{
    /** @var array<string, mixed>|null */
    private static ?array $legacyCache = null;

    /**
     * @return array<string, mixed>
     */
    protected function legacyVars(): array
    {
        if (self::$legacyCache !== null) {
            return self::$legacyCache;
        }

        require_once ROOTPATH . 'includes/legacy-env.php';

        $nav_items            = null;
        $agency_services      = null;
        $blog_posts           = null;
        $blog_categories      = null;
        $blog_tags            = null;
        $homepage_projects    = null;
        $homepage_features    = null;
        $homepage_counters    = null;
        $company_leadership   = null;
        $about_skills         = null;
        $team_members         = null;
        $testimonials         = null;
        $brand_logos          = null;
        $office_locations     = null;
        $social_links         = null;
        $sitemap_pages        = null;
        $translations         = null;

        require ROOTPATH . 'includes/config.php';

        self::$legacyCache = compact(
            'nav_items',
            'agency_services',
            'blog_posts',
            'blog_categories',
            'blog_tags',
            'homepage_projects',
            'homepage_features',
            'homepage_counters',
            'company_leadership',
            'about_skills',
            'team_members',
            'testimonials',
            'brand_logos',
            'office_locations',
            'social_links',
            'sitemap_pages',
            'translations',
        );

        return self::$legacyCache;
    }

    protected function loadLegacyConfig(): void
    {
        $this->legacyVars();
    }
}
