<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeedIntegrationSettings extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('site_settings')) {
            return;
        }

        $defaults = [
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

        foreach ($defaults as $row) {
            $exists = $this->db->table('site_settings')
                ->where('setting_key', $row['setting_key'])
                ->countAllResults();

            if ($exists === 0) {
                $this->db->table('site_settings')->insert($row);
            }
        }
    }

    public function down()
    {
        // Données de configuration — pas de rollback destructif.
    }
}
