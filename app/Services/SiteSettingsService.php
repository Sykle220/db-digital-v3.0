<?php

namespace App\Services;

use App\Libraries\DbGuard;
use App\Models\SettingModel;

class SiteSettingsService
{
    /** @var array<string, string>|null */
    protected static ?array $cache = null;

    /**
     * @param array<string, string> $defaults
     *
     * @return array<string, string>
     */
    public function all(array $defaults = []): array
    {
        if (self::$cache !== null) {
            return array_merge($defaults, self::$cache);
        }

        self::$cache = [];

        if (DbGuard::available()) {
            $rows = model(SettingModel::class)->findAll();
            foreach ($rows as $row) {
                $key = (string) ($row['setting_key'] ?? '');
                if ($key !== '') {
                    self::$cache[$key] = (string) ($row['setting_value'] ?? '');
                }
            }
        }

        return array_merge($defaults, self::$cache);
    }

    public function get(string $key, string $default = ''): string
    {
        $all = $this->all();

        return $all[$key] ?? $default;
    }

    public function clearCache(): void
    {
        self::$cache = null;
    }

    public function integrations(): array
    {
        $s = $this->all();

        return [
            'tracking_enabled'      => filter_var($s['tracking_enabled'] ?? '1', FILTER_VALIDATE_BOOLEAN),
            'gtm_container_id'      => (string) ($s['gtm_container_id'] ?? ''),
            'ga4_measurement_id'    => (string) ($s['ga4_measurement_id'] ?? ''),
            'meta_pixel_id'         => (string) ($s['meta_pixel_id'] ?? ''),
            'linkedin_partner_id'   => (string) ($s['linkedin_partner_id'] ?? ''),
            'hotjar_site_id'        => (string) ($s['hotjar_site_id'] ?? ''),
            'clarity_project_id'    => (string) ($s['clarity_project_id'] ?? ''),
            'cookie_banner_enabled' => filter_var($s['cookie_banner_enabled'] ?? '1', FILTER_VALIDATE_BOOLEAN),
            'cookie_policy_text_fr' => (string) ($s['cookie_policy_text_fr'] ?? ''),
            'cookie_policy_text_en' => (string) ($s['cookie_policy_text_en'] ?? ''),
            'privacy_page_slug_fr'  => (string) ($s['privacy_page_slug_fr'] ?? 'politique-confidentialite'),
            'privacy_page_slug_en'  => (string) ($s['privacy_page_slug_en'] ?? 'privacy-policy'),
            'legal_page_slug_fr'    => (string) ($s['legal_page_slug_fr'] ?? 'mentions-legales'),
            'legal_page_slug_en'    => (string) ($s['legal_page_slug_en'] ?? 'legal-notice'),
            'recaptcha_enabled'     => filter_var($s['recaptcha_enabled'] ?? '0', FILTER_VALIDATE_BOOLEAN),
            'recaptcha_site_key'    => (string) ($s['recaptcha_site_key'] ?? ''),
            'cdn_assets_url'        => rtrim((string) ($s['cdn_assets_url'] ?? ''), '/'),
            'defer_scripts'         => filter_var($s['defer_scripts'] ?? '1', FILTER_VALIDATE_BOOLEAN),
            'lazy_images'           => filter_var($s['lazy_images'] ?? '1', FILTER_VALIDATE_BOOLEAN),
            'preload_fonts'         => filter_var($s['preload_fonts'] ?? '1', FILTER_VALIDATE_BOOLEAN),
            'assets_minified'       => filter_var($s['assets_minified'] ?? '0', FILTER_VALIDATE_BOOLEAN),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function socialLinks(): array
    {
        $settings = $this->all();

        return array_filter([
            'facebook' => $settings['facebook_url'] ?? $settings['social_facebook'] ?? '',
            'linkedin' => $settings['linkedin_url'] ?? $settings['social_linkedin'] ?? '',
            'youtube'  => $settings['youtube_url'] ?? $settings['social_youtube'] ?? '',
            'tiktok'   => $settings['tiktok_url'] ?? $settings['social_tiktok'] ?? '',
        ]);
    }
}
