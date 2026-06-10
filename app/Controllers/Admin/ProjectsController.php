<?php

namespace App\Controllers\Admin;

use App\Models\ProjectModel;

class ProjectsController extends BaseAdminController
{
    protected string $pageTitle  = 'Projets';
    protected string $activeMenu = 'projects';

    protected ProjectModel $model;

    /** @var list<string> */
    protected array $translationFields = ['title', 'description', 'category', 'client'];

    public function __construct()
    {
        $this->model = model(ProjectModel::class);
    }

    public function index()
    {
        $items = $this->model->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $tr = $this->loadTranslations('project_translations', 'project_id', (int) $item['id'], ['title']);
            $item['title_fr'] = $tr['fr']['title'] ?? '';
            $item['title_en'] = $tr['en']['title'] ?? '';
        }
        unset($item);

        return $this->render('admin/projects/index', ['items' => $items]);
    }

    public function create()
    {
        return $this->render('admin/projects/form', [
            'item'         => null,
            'translations' => $this->emptyTranslations(),
            'action'       => site_url('admin/projects'),
        ]);
    }

    public function store()
    {
        if (! $this->validate(['slug' => 'required|is_unique[projects.slug]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert($this->baseData(), true);
        $this->saveTranslations('project_translations', 'project_id', (int) $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('create', 'project', (int) $id);

        return redirect()->to('admin/projects')->with('success', 'Projet créé.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/projects')->with('error', 'Projet introuvable.');
        }

        return $this->render('admin/projects/form', [
            'item'         => $item,
            'translations' => $this->loadTranslations('project_translations', 'project_id', $id, $this->translationFields),
            'action'       => site_url('admin/projects/' . $id),
        ]);
    }

    public function update(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/projects')->with('error', 'Projet introuvable.');
        }

        if (! $this->validate(['slug' => "required|is_unique[projects.slug,id,{$id}]"])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, $this->baseData());
        $this->saveTranslations('project_translations', 'project_id', $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('update', 'project', $id);

        return redirect()->to('admin/projects')->with('success', 'Projet mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/projects')->with('error', 'Projet introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'project', $id);

        return redirect()->to('admin/projects')->with('success', 'Projet supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        return [
            'slug'       => $this->request->getPost('slug'),
            'image'      => $this->request->getPost('image'),
            'col_lg'     => (int) ($this->request->getPost('col_lg') ?? 4),
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
