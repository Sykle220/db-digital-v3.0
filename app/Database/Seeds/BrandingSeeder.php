<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BrandingSeeder extends Seeder
{
    public function run(): void
    {
        if (! $this->db->tableExists('site_branding')) {
            return;
        }

        $map = [
            'logo_light_id'       => ['w_logo02.png', 'branding'],
            'logo_dark_id'        => ['logo.png', 'branding'],
            'logo_mobile_id'      => ['w_logo.png', 'branding'],
            'favicon_id'          => ['favicon.png', 'branding'],
            'apple_touch_icon_id' => ['favicon.png', 'branding'],
            'og_default_image_id' => ['about_ceo.png', 'images'],
        ];

        $payload = ['updated_at' => date('Y-m-d H:i:s')];

        foreach ($map as $field => [$filename, $folder]) {
            $media = $this->findMedia($filename, $folder);
            $payload[$field] = $media !== null ? (int) $media['id'] : null;
        }

        $existing = $this->db->table('site_branding')->orderBy('id', 'DESC')->get()->getRowArray();
        if ($existing) {
            $this->db->table('site_branding')->where('id', (int) $existing['id'])->update($payload);
        } else {
            $this->db->table('site_branding')->insert($payload);
        }
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function findMedia(string $filename, string $folder): ?array
    {
        if (! $this->db->tableExists('media')) {
            return null;
        }

        $row = $this->db->table('media')
            ->where('folder', $folder)
            ->where('original_name', $filename)
            ->get()
            ->getRowArray();

        return $row ?: null;
    }
}
