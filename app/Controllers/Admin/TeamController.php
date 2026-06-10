<?php

namespace App\Controllers\Admin;

use App\Models\TeamMemberModel;

class TeamController extends BaseAdminController
{
    protected string $pageTitle  = 'Équipe';
    protected string $activeMenu = 'team';

    protected TeamMemberModel $model;

    /** @var list<string> */
    protected array $translationFields = ['name', 'role', 'bio'];

    public function __construct()
    {
        $this->model = model(TeamMemberModel::class);
    }

    public function index()
    {
        $items = $this->model->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $tr = $this->loadTranslations('team_member_translations', 'team_member_id', (int) $item['id'], ['name']);
            $item['name_fr'] = $tr['fr']['name'] ?? '';
            $item['name_en'] = $tr['en']['name'] ?? '';
        }
        unset($item);

        return $this->render('admin/team/index', ['items' => $items]);
    }

    public function create()
    {
        return $this->render('admin/team/form', [
            'item'         => null,
            'translations' => $this->emptyTranslations(),
            'action'       => site_url('admin/team'),
        ]);
    }

    public function store()
    {
        $id = $this->model->insert($this->baseData(), true);
        $this->saveTranslations('team_member_translations', 'team_member_id', (int) $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('create', 'team_member', (int) $id);

        return redirect()->to('admin/team')->with('success', 'Membre ajouté.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/team')->with('error', 'Membre introuvable.');
        }

        return $this->render('admin/team/form', [
            'item'         => $item,
            'translations' => $this->loadTranslations('team_member_translations', 'team_member_id', $id, $this->translationFields),
            'action'       => site_url('admin/team/' . $id),
        ]);
    }

    public function update(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/team')->with('error', 'Membre introuvable.');
        }

        $this->model->update($id, $this->baseData());
        $this->saveTranslations('team_member_translations', 'team_member_id', $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('update', 'team_member', $id);

        return redirect()->to('admin/team')->with('success', 'Membre mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/team')->with('error', 'Membre introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'team_member', $id);

        return redirect()->to('admin/team')->with('success', 'Membre supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        return [
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
