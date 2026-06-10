<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeoSeeder extends Seeder
{
    use LegacyConfigTrait;

    public function run(): void
    {
        if (! $this->db->tableExists('seo_sitemap_config')) {
            return;
        }

        $defaults = [
            ['entity_type' => 'home', 'changefreq' => 'weekly', 'priority' => 1.0],
            ['entity_type' => 'page', 'changefreq' => 'monthly', 'priority' => 0.8],
            ['entity_type' => 'service', 'changefreq' => 'monthly', 'priority' => 0.9],
            ['entity_type' => 'project', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['entity_type' => 'blog', 'changefreq' => 'weekly', 'priority' => 0.7],
            ['entity_type' => 'quote', 'changefreq' => 'monthly', 'priority' => 0.6],
            ['entity_type' => 'contact', 'changefreq' => 'monthly', 'priority' => 0.8],
        ];

        foreach ($defaults as $row) {
            $existing = $this->db->table('seo_sitemap_config')
                ->where('entity_type', $row['entity_type'])
                ->get()
                ->getRowArray();

            $payload = array_merge($row, ['is_included' => 1]);

            if ($existing) {
                $this->db->table('seo_sitemap_config')->where('id', $existing['id'])->update($payload);
            } else {
                $this->db->table('seo_sitemap_config')->insert($payload);
            }
        }

        $this->seedLegacyRedirects();
    }

    protected function seedLegacyRedirects(): void
    {
        if (! $this->db->tableExists('seo_redirects')) {
            return;
        }

        $legacy = config('LegacyRedirects');
        if (! is_object($legacy) || ! is_array($legacy->map ?? null)) {
            return;
        }

        foreach ($legacy->map as $from => $to) {
            $existing = $this->db->table('seo_redirects')
                ->where('from_path', $from)
                ->get()
                ->getRowArray();

            if ($existing) {
                continue;
            }

            $this->db->table('seo_redirects')->insert([
                'from_path'   => $from,
                'to_path'     => $to,
                'status_code' => 301,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
