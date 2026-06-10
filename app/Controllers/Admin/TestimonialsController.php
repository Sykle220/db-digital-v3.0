<?php

namespace App\Controllers\Admin;

use App\Models\TestimonialModel;

class TestimonialsController extends BaseAdminController
{
    protected string $pageTitle  = 'Témoignages';
    protected string $activeMenu = 'testimonials';

    protected TestimonialModel $model;

    /** @var list<string> */
    protected array $translationFields = ['author', 'role', 'quote'];

    public function __construct()
    {
        $this->model = model(TestimonialModel::class);
    }

    public function index()
    {
        $items = $this->model->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $tr = $this->loadTranslations('testimonial_translations', 'testimonial_id', (int) $item['id'], ['author']);
            $item['name_fr'] = $tr['fr']['author'] ?? '';
            $item['name_en'] = $tr['en']['author'] ?? '';
        }
        unset($item);

        return $this->render('admin/testimonials/index', ['items' => $items]);
    }

    public function create()
    {
        return $this->render('admin/testimonials/form', [
            'item'         => null,
            'translations' => $this->emptyTranslations(),
            'action'       => site_url('admin/testimonials'),
        ]);
    }

    public function store()
    {
        $id = $this->model->insert($this->baseData(), true);
        $this->saveTranslations('testimonial_translations', 'testimonial_id', (int) $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('create', 'testimonial', (int) $id);

        return redirect()->to('admin/testimonials')->with('success', 'Témoignage créé.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/testimonials')->with('error', 'Témoignage introuvable.');
        }

        return $this->render('admin/testimonials/form', [
            'item'         => $item,
            'translations' => $this->loadTranslations('testimonial_translations', 'testimonial_id', $id, $this->translationFields),
            'action'       => site_url('admin/testimonials/' . $id),
        ]);
    }

    public function update(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/testimonials')->with('error', 'Témoignage introuvable.');
        }

        $this->model->update($id, $this->baseData());
        $this->saveTranslations('testimonial_translations', 'testimonial_id', $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('update', 'testimonial', $id);

        return redirect()->to('admin/testimonials')->with('success', 'Témoignage mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/testimonials')->with('error', 'Témoignage introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'testimonial', $id);

        return redirect()->to('admin/testimonials')->with('success', 'Témoignage supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        return [
            'image'      => $this->request->getPost('image'),
            'rating'     => (int) ($this->request->getPost('rating') ?? 5),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active'  => (int) ($this->request->getPost('is_active') ?? 0),
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
