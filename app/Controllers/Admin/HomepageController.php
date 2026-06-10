<?php

namespace App\Controllers\Admin;

class HomepageController extends BaseAdminController
{
    protected string $pageTitle  = 'Page d\'accueil';
    protected string $activeMenu = 'homepage';

    public function index()
    {
        $content  = service('content');
        $features = $content->getHomepageFeatures('fr');
        $counters = $content->getHomepageCounters();
        $leader   = $content->getCompanyLeadership();

        return $this->render('admin/homepage/index', [
            'features' => $features,
            'counters' => $counters,
            'leader'   => $leader,
            'action'   => site_url('admin/homepage'),
        ]);
    }

    public function update()
    {
        $db = model(\App\Models\ServiceModel::class)->db;

        $features = [];
        foreach ($this->request->getPost('features') ?? [] as $row) {
            if (! is_array($row) || trim((string) ($row['title_key'] ?? '')) === '') {
                continue;
            }
            $features[] = [
                'icon'      => (string) ($row['icon'] ?? ''),
                'title_key' => (string) ($row['title_key'] ?? ''),
                'desc_fr'   => (string) ($row['desc_fr'] ?? ''),
                'desc_en'   => (string) ($row['desc_en'] ?? ''),
            ];
        }

        $counters = [];
        foreach ($this->request->getPost('counters') ?? [] as $row) {
            if (! is_array($row)) {
                continue;
            }
            $counters[] = [
                'icon'      => (string) ($row['icon'] ?? ''),
                'label_key' => (string) ($row['label_key'] ?? ''),
                'count'     => (int) ($row['count'] ?? 0),
            ];
        }

        $leader = [
            'ceo_name'         => (string) ($this->request->getPost('ceo_name') ?? ''),
            'ceo_image'        => (string) ($this->request->getPost('ceo_image') ?? ''),
            'signature_image'  => (string) ($this->request->getPost('signature_image') ?? ''),
            'experience_years' => (string) ($this->request->getPost('experience_years') ?? ''),
        ];

        $this->saveHomepageSection($db, 'features', [
            'fr' => ['items' => array_map(static fn ($f) => ['icon' => $f['icon'], 'title_key' => $f['title_key'], 'desc' => $f['desc_fr']], $features)],
            'en' => ['items' => array_map(static fn ($f) => ['icon' => $f['icon'], 'title_key' => $f['title_key'], 'desc' => $f['desc_en']], $features)],
        ]);

        $this->saveHomepageSection($db, 'counters', [
            'fr' => $counters,
            'en' => $counters,
        ]);

        $this->saveHomepageSection($db, 'leadership', [
            'fr' => $leader,
            'en' => $leader,
        ]);

        $this->logActivity('update', 'homepage');

        return redirect()->to('admin/homepage')->with('success', 'Page d\'accueil enregistrée.');
    }

    /**
     * @param array<string, mixed> $byLocale
     */
    protected function saveHomepageSection($db, string $key, array $byLocale): void
    {
        if (! $db->tableExists('homepage_sections') || ! $db->tableExists('section_translations')) {
            return;
        }

        $section = $db->table('homepage_sections')->where('key', $key)->get()->getRowArray();
        if ($section) {
            $sectionId = (int) $section['id'];
        } else {
            $db->table('homepage_sections')->insert(['key' => $key, 'sort_order' => 0, 'is_active' => 1]);
            $sectionId = (int) $db->insertID();
        }

        foreach ($byLocale as $locale => $data) {
            $payload = [
                'section_id' => $sectionId,
                'locale'     => $locale,
                'data'       => json_encode($data, JSON_UNESCAPED_UNICODE),
            ];

            $existing = $db->table('section_translations')
                ->where('section_id', $sectionId)
                ->where('locale', $locale)
                ->get()
                ->getRowArray();

            if ($existing) {
                $db->table('section_translations')->where('id', $existing['id'])->update($payload);
            } else {
                $db->table('section_translations')->insert($payload);
            }
        }
    }
}
