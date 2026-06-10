<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PageSeeder extends Seeder
{
    use LegalPagesContent;

    public function run(): void
    {
        if (! $this->db->tableExists('pages')) {
            return;
        }

        $legalDefs = $this->legalPagesDefinitions();

        $pages = [
            [
                'key'      => 'about',
                'template' => 'about',
                'slug'     => ['fr' => 'a-propos', 'en' => 'about'],
                'title'    => ['fr' => 'À Propos', 'en' => 'About Us'],
            ],
            [
                'key'      => 'contact',
                'template' => 'contact',
                'slug'     => ['fr' => 'contact', 'en' => 'contact'],
                'title'    => ['fr' => 'Contact', 'en' => 'Contact'],
            ],
            [
                'key'      => 'mentions-legales',
                'template' => 'legal',
                'legal'    => 'mentions-legales',
                'slug'     => ['fr' => 'mentions-legales', 'en' => 'legal-notice'],
                'title'    => ['fr' => 'Mentions légales', 'en' => 'Legal notice'],
            ],
            [
                'key'      => 'politique-confidentialite',
                'template' => 'legal',
                'legal'    => 'politique-confidentialite',
                'slug'     => ['fr' => 'politique-confidentialite', 'en' => 'privacy-policy'],
                'title'    => ['fr' => 'Politique de confidentialité', 'en' => 'Privacy policy'],
            ],
        ];

        foreach ($pages as $index => $pageDef) {
            $slugFr = $pageDef['slug']['fr'];
            $pageId = $this->resolvePageId($slugFr, $pageDef['template'], $index + 1);

            foreach (['fr', 'en'] as $locale) {
                $slug  = $pageDef['slug'][$locale];
                $title = $pageDef['title'][$locale];

                $legalKey = $pageDef['legal'] ?? null;
                $legal    = $legalKey !== null ? ($legalDefs[$legalKey][$locale] ?? []) : [];

                $content = (string) ($legal['content'] ?? ($pageDef['content'][$locale] ?? ''));
                $excerpt = (string) ($legal['excerpt'] ?? '');
                $metaDesc = (string) ($legal['meta_description'] ?? '');

                $row = $this->db->table('page_translations')
                    ->where('page_id', $pageId)
                    ->where('locale', $locale)
                    ->get()
                    ->getRowArray();

                $payload = [
                    'page_id'          => $pageId,
                    'locale'           => $locale,
                    'title'            => $title,
                    'slug'             => $slug,
                    'excerpt'          => $excerpt,
                    'content'          => $content,
                    'meta_title'       => $title . ' | DB Digital Agency',
                    'meta_description' => $metaDesc,
                ];

                if ($row) {
                    unset($payload['page_id'], $payload['locale']);
                    $this->db->table('page_translations')->where('id', $row['id'])->update($payload);
                } else {
                    $this->db->table('page_translations')->insert($payload);
                }
            }
        }
    }

    protected function resolvePageId(string $slugFr, string $template, int $sortOrder): int
    {
        $existing = $this->db->table('page_translations')
            ->where('slug', $slugFr)
            ->where('locale', 'fr')
            ->get()
            ->getRowArray();

        if ($existing) {
            return (int) $existing['page_id'];
        }

        $this->db->table('pages')->insert([
            'template'     => $template,
            'sort_order'   => $sortOrder,
            'is_published' => 1,
            'published_at' => date('Y-m-d H:i:s'),
            'created_by'   => null,
        ]);

        return (int) $this->db->insertID();
    }
}
