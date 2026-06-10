<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    use LegacyConfigTrait;

    public function run(): void
    {
        if (! $this->db->tableExists('site_settings')) {
            return;
        }

        $this->loadLegacyConfig();

        $legacy     = $this->legacyVars();
        $social     = $legacy['social_links'] ?? [];
        $blogTags   = $legacy['blog_tags'] ?? [];

        $settings = [
            ['setting_key' => 'site_name', 'setting_value' => SITE_NAME, 'setting_group' => 'general'],
            ['setting_key' => 'site_url', 'setting_value' => SITE_URL, 'setting_group' => 'general'],
            ['setting_key' => 'contact_address', 'setting_value' => CONTACT_ADDRESS, 'setting_group' => 'contact'],
            ['setting_key' => 'contact_phone', 'setting_value' => CONTACT_PHONE_1, 'setting_group' => 'contact'],
            ['setting_key' => 'contact_phone_1', 'setting_value' => CONTACT_PHONE_1, 'setting_group' => 'contact'],
            ['setting_key' => 'contact_phone_2', 'setting_value' => CONTACT_PHONE_2, 'setting_group' => 'contact'],
            ['setting_key' => 'contact_phone_3', 'setting_value' => CONTACT_PHONE_3, 'setting_group' => 'contact'],
            ['setting_key' => 'contact_email', 'setting_value' => CONTACT_EMAIL, 'setting_group' => 'contact'],
            ['setting_key' => 'whatsapp_number', 'setting_value' => WHATSAPP_NUMBER, 'setting_group' => 'contact'],
            ['setting_key' => 'admin_email', 'setting_value' => ADMIN_EMAIL, 'setting_group' => 'email'],
            ['setting_key' => 'smtp_host', 'setting_value' => SMTP_HOST, 'setting_group' => 'email'],
            ['setting_key' => 'smtp_port', 'setting_value' => (string) SMTP_PORT, 'setting_group' => 'email'],
            ['setting_key' => 'smtp_username', 'setting_value' => SMTP_USERNAME, 'setting_group' => 'email'],
            ['setting_key' => 'smtp_encryption', 'setting_value' => SMTP_ENCRYPTION, 'setting_group' => 'email'],
            ['setting_key' => 'smtp_from_email', 'setting_value' => SMTP_FROM_EMAIL, 'setting_group' => 'email'],
            ['setting_key' => 'smtp_from_name', 'setting_value' => SMTP_FROM_NAME, 'setting_group' => 'email'],
            ['setting_key' => 'seo_index', 'setting_value' => (string) env('SEO_INDEX', 'true'), 'setting_group' => 'seo'],
            ['setting_key' => 'facebook_url', 'setting_value' => (string) ($social['facebook'] ?? ''), 'setting_group' => 'social'],
            ['setting_key' => 'linkedin_url', 'setting_value' => (string) ($social['linkedin'] ?? ''), 'setting_group' => 'social'],
            ['setting_key' => 'youtube_url', 'setting_value' => (string) ($social['youtube'] ?? ''), 'setting_group' => 'social'],
            ['setting_key' => 'tiktok_url', 'setting_value' => (string) ($social['tiktok'] ?? ''), 'setting_group' => 'social'],
            ['setting_key' => 'blog_tags', 'setting_value' => json_encode($blogTags, JSON_UNESCAPED_UNICODE), 'setting_group' => 'content'],
            ['setting_key' => 'tracking_enabled', 'setting_value' => '1', 'setting_group' => 'integrations'],
            ['setting_key' => 'cookie_banner_enabled', 'setting_value' => '1', 'setting_group' => 'integrations'],
            ['setting_key' => 'recaptcha_enabled', 'setting_value' => '0', 'setting_group' => 'integrations'],
            ['setting_key' => 'form_rate_limit_max', 'setting_value' => '8', 'setting_group' => 'integrations'],
            ['setting_key' => 'form_rate_limit_minutes', 'setting_value' => '15', 'setting_group' => 'integrations'],
            ['setting_key' => 'defer_scripts', 'setting_value' => '1', 'setting_group' => 'integrations'],
            ['setting_key' => 'lazy_images', 'setting_value' => '1', 'setting_group' => 'integrations'],
            ['setting_key' => 'preload_fonts', 'setting_value' => '1', 'setting_group' => 'integrations'],
            ['setting_key' => 'privacy_page_slug_fr', 'setting_value' => 'politique-confidentialite', 'setting_group' => 'integrations'],
            ['setting_key' => 'privacy_page_slug_en', 'setting_value' => 'privacy-policy', 'setting_group' => 'integrations'],
            ['setting_key' => 'legal_page_slug_fr', 'setting_value' => 'mentions-legales', 'setting_group' => 'integrations'],
            ['setting_key' => 'legal_page_slug_en', 'setting_value' => 'legal-notice', 'setting_group' => 'integrations'],
            ['setting_key' => 'sitemap_enabled', 'setting_value' => '1', 'setting_group' => 'seo'],
            ['setting_key' => 'sitemap_changefreq', 'setting_value' => 'weekly', 'setting_group' => 'seo'],
            ['setting_key' => 'sitemap_priority', 'setting_value' => '0.8', 'setting_group' => 'seo'],
        ];

        foreach ($social as $network => $url) {
            $settings[] = [
                'setting_key'   => 'social_' . $network,
                'setting_value' => $url,
                'setting_group' => 'social',
            ];
        }

        foreach ($settings as $row) {
            $existing = $this->db->table('site_settings')
                ->where('setting_key', $row['setting_key'])
                ->get()
                ->getRowArray();

            if ($existing) {
                $this->db->table('site_settings')
                    ->where('id', $existing['id'])
                    ->update([
                        'setting_value' => $row['setting_value'],
                        'setting_group' => $row['setting_group'],
                    ]);
            } else {
                $this->db->table('site_settings')->insert($row);
            }
        }
    }
}
