<?php

namespace App\Controllers\Admin;

use App\Models\ServiceModel;

class ServicesController extends BaseAdminController
{
    protected string $pageTitle  = 'Services';
    protected string $activeMenu = 'services';

    protected ServiceModel $model;

    /** @var list<string> */
    protected array $translationFields = [
        'title', 'description', 'intro', 'body',
        'highlight_title', 'highlight_text',
        'goal_title', 'goal_text',
        'challenge_title', 'challenge_text',
        'benefits',
    ];

    public function __construct()
    {
        $this->model = model(ServiceModel::class);
    }

    public function index()
    {
        $items = $this->model->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $tr = $this->loadTranslations('service_translations', 'service_id', (int) $item['id'], ['title']);
            $item['title_fr'] = $tr['fr']['title'] ?? '';
            $item['title_en'] = $tr['en']['title'] ?? '';
        }
        unset($item);

        return $this->render('admin/services/index', ['items' => $items]);
    }

    public function create()
    {
        return $this->render('admin/services/form', [
            'item'         => null,
            'translations' => $this->emptyTranslations(),
            'faqs'         => [],
            'action'       => site_url('admin/services'),
        ]);
    }

    public function store()
    {
        if (! $this->validate(['slug' => 'required|is_unique[services.slug]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert($this->baseData(), true);
        $this->saveServiceTranslations((int) $id);
        $this->saveFaqs((int) $id);
        $this->logActivity('create', 'service', (int) $id);

        return redirect()->to('admin/services')->with('success', 'Service créé.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/services')->with('error', 'Service introuvable.');
        }

        $translations = $this->loadTranslations('service_translations', 'service_id', $id, $this->translationFields);
        foreach ($this->locales() as $locale) {
            $benefits = $translations[$locale]['benefits'] ?? '';
            if (is_string($benefits) && str_starts_with(trim($benefits), '[')) {
                $decoded = json_decode($benefits, true);
                if (is_array($decoded)) {
                    $translations[$locale]['benefits'] = implode("\n", array_map('strval', $decoded));
                }
            }
        }

        return $this->render('admin/services/form', [
            'item'         => $item,
            'translations' => $translations,
            'faqs'         => $this->loadFaqs($id),
            'action'       => site_url('admin/services/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/services')->with('error', 'Service introuvable.');
        }

        if (! $this->validate(['slug' => "required|is_unique[services.slug,id,{$id}]"])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, $this->baseData());
        $this->saveServiceTranslations($id);
        $this->saveFaqs($id);
        $this->logActivity('update', 'service', $id);

        return redirect()->to('admin/services')->with('success', 'Service mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/services')->with('error', 'Service introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'service', $id);

        return redirect()->to('admin/services')->with('success', 'Service supprimé.');
    }

    protected function saveServiceTranslations(int $serviceId): void
    {
        $input = $this->request->getPost('translations') ?? [];
        $db    = $this->model->db;

        foreach ($this->locales() as $locale) {
            $row = [
                'service_id' => $serviceId,
                'locale'     => $locale,
            ];

            foreach ($this->translationFields as $field) {
                $value = $input[$locale][$field] ?? '';
                if ($field === 'benefits') {
                    $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $value) ?: [])));
                    $value = json_encode($lines, JSON_UNESCAPED_UNICODE);
                }
                $row[$field] = $value;
            }

            $existing = $db->table('service_translations')
                ->where('service_id', $serviceId)
                ->where('locale', $locale)
                ->get()
                ->getRowArray();

            if ($existing) {
                $db->table('service_translations')->where('id', $existing['id'])->update($row);
            } else {
                $db->table('service_translations')->insert($row);
            }
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function loadFaqs(int $serviceId): array
    {
        $db = $this->model->db;
        if (! $db->tableExists('service_faqs')) {
            return [];
        }

        $faqs = $db->table('service_faqs')
            ->where('service_id', $serviceId)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($faqs as &$faq) {
            $faqId = (int) $faq['id'];
            foreach ($this->locales() as $locale) {
                $tr = $db->table('faq_translations')
                    ->where('faq_id', $faqId)
                    ->where('locale', $locale)
                    ->get()
                    ->getRowArray();
                $faq['question_' . $locale] = $tr['question'] ?? '';
                $faq['answer_' . $locale]   = $tr['answer'] ?? '';
            }
        }
        unset($faq);

        return $faqs;
    }

    protected function saveFaqs(int $serviceId): void
    {
        $db = $this->model->db;
        if (! $db->tableExists('service_faqs')) {
            return;
        }

        $faqs = $this->request->getPost('faqs') ?? [];
        if (! is_array($faqs)) {
            return;
        }

        $db->table('service_faqs')->where('service_id', $serviceId)->delete();

        $sort = 0;
        foreach ($faqs as $faq) {
            if (! is_array($faq)) {
                continue;
            }

            $hasContent = false;
            foreach ($this->locales() as $locale) {
                if (trim((string) ($faq['question_' . $locale] ?? '')) !== '') {
                    $hasContent = true;
                    break;
                }
            }
            if (! $hasContent) {
                continue;
            }

            $sort++;
            $db->table('service_faqs')->insert([
                'service_id' => $serviceId,
                'sort_order' => $sort,
            ]);
            $faqId = (int) $db->insertID();

            foreach ($this->locales() as $locale) {
                $db->table('faq_translations')->insert([
                    'faq_id'   => $faqId,
                    'locale'   => $locale,
                    'question' => (string) ($faq['question_' . $locale] ?? ''),
                    'answer'   => (string) ($faq['answer_' . $locale] ?? ''),
                ]);
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        return [
            'slug'         => $this->request->getPost('slug'),
            'icon'         => $this->request->getPost('icon'),
            'image'        => $this->request->getPost('image'),
            'detail_image' => $this->request->getPost('detail_image'),
            'quote_icon'   => $this->request->getPost('quote_icon'),
            'quote_color'  => $this->request->getPost('quote_color'),
            'quote_bg'     => $this->request->getPost('quote_bg'),
            'sort_order'   => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active'    => (int) ($this->request->getPost('is_active') ?? 0),
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    protected function emptyTranslations(): array
    {
        $out = [];
        foreach ($this->locales() as $locale) {
            $out[$locale] = array_fill_keys($this->translationFields, '');
        }

        return $out;
    }
}
