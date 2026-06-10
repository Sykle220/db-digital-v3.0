<?php

namespace App\Controllers\Admin;

use App\Models\OfficeLocationModel;

class OfficesController extends BaseAdminController
{
    protected string $pageTitle  = 'Bureaux';
    protected string $activeMenu = 'offices';

    protected OfficeLocationModel $model;

    /** @var list<string> */
    protected array $translationFields = ['city', 'label', 'address'];

    public function __construct()
    {
        $this->model = model(OfficeLocationModel::class);
    }

    public function index()
    {
        $items = $this->model->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $tr = $this->loadTranslations('office_location_translations', 'location_id', (int) $item['id'], ['city', 'label']);
            $item['name_fr'] = $tr['fr']['label'] ?? $tr['fr']['city'] ?? '';
            $item['name_en'] = $tr['en']['label'] ?? $tr['en']['city'] ?? '';
        }
        unset($item);

        return $this->render('admin/offices/index', ['items' => $items]);
    }

    public function create()
    {
        return $this->render('admin/offices/form', [
            'item'         => null,
            'translations' => $this->emptyTranslations(),
            'action'       => site_url('admin/offices'),
        ]);
    }

    public function store()
    {
        $id = $this->model->insert($this->baseData(), true);
        $this->saveTranslations('office_location_translations', 'location_id', (int) $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('create', 'office', (int) $id);

        return redirect()->to('admin/offices')->with('success', 'Bureau créé.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/offices')->with('error', 'Bureau introuvable.');
        }

        return $this->render('admin/offices/form', [
            'item'         => $item,
            'translations' => $this->loadTranslations('office_location_translations', 'location_id', $id, $this->translationFields),
            'action'       => site_url('admin/offices/' . $id),
        ]);
    }

    public function update(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/offices')->with('error', 'Bureau introuvable.');
        }

        $this->model->update($id, $this->baseData());
        $this->saveTranslations('office_location_translations', 'location_id', $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('update', 'office', $id);

        return redirect()->to('admin/offices')->with('success', 'Bureau mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/offices')->with('error', 'Bureau introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'office', $id);

        return redirect()->to('admin/offices')->with('success', 'Bureau supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        return [
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'lat'        => $this->request->getPost('lat'),
            'lng'        => $this->request->getPost('lng'),
            'image'      => $this->request->getPost('image'),
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
