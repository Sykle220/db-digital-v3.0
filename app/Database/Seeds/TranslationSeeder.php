<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        if (! $this->db->tableExists('translation_keys')) {
            return;
        }

        $locales = [
            'fr' => require ROOTPATH . 'includes/lang/fr.php',
            'en' => require ROOTPATH . 'includes/lang/en.php',
        ];

        $allKeys = array_unique(array_merge(array_keys($locales['fr']), array_keys($locales['en'])));

        foreach ($allKeys as $key) {
            $group = $this->inferGroup($key);

            $existing = $this->db->table('translation_keys')
                ->where('key', $key)
                ->get()
                ->getRowArray();

            if ($existing) {
                $keyId = (int) $existing['id'];
            } else {
                $this->db->table('translation_keys')->insert([
                    'key'         => $key,
                    'group'       => $group,
                    'description' => null,
                ]);
                $keyId = (int) $this->db->insertID();
            }

            foreach ($locales as $locale => $strings) {
                if (! isset($strings[$key])) {
                    continue;
                }

                $value = (string) $strings[$key];
                $row   = $this->db->table('translation_values')
                    ->where('key_id', $keyId)
                    ->where('locale', $locale)
                    ->get()
                    ->getRowArray();

                if ($row) {
                    $this->db->table('translation_values')
                        ->where('id', $row['id'])
                        ->update(['value' => $value]);
                } else {
                    $this->db->table('translation_values')->insert([
                        'key_id' => $keyId,
                        'locale' => $locale,
                        'value'  => $value,
                    ]);
                }
            }
        }
    }

    protected function inferGroup(string $key): string
    {
        $prefix = explode('_', $key)[0] ?? 'app';

        return match ($prefix) {
            'nav'     => 'navigation',
            'btn'     => 'buttons',
            'meta'    => 'seo',
            'quote'   => 'quote',
            'contact' => 'contact',
            'footer'  => 'footer',
            default   => 'app',
        };
    }
}
