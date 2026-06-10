<?php

namespace App\Controllers\Admin;

use App\Models\BrandLogoModel;

class BrandLogosController extends BaseAdminController
{
    protected string $pageTitle  = 'Logos partenaires';
    protected string $activeMenu = 'brand-logos';

    protected BrandLogoModel $model;

    public function __construct()
    {
        $this->model = model(BrandLogoModel::class);
    }

    public function index()
    {
        return $this->render('admin/brand-logos/index', [
            'items' => $this->model->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->render('admin/brand-logos/form', [
            'item'   => null,
            'action' => site_url('admin/brand-logos'),
        ]);
    }

    public function store()
    {
        if (! $this->validate(['filename' => 'required|max_length[255]', 'name' => 'required|max_length[255]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert($this->baseData(), true);
        $this->logActivity('create', 'brand_logo', (int) $id);

        return redirect()->to('admin/brand-logos')->with('success', 'Logo ajouté.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/brand-logos')->with('error', 'Logo introuvable.');
        }

        return $this->render('admin/brand-logos/form', [
            'item'   => $item,
            'action' => site_url('admin/brand-logos/' . $id),
        ]);
    }

    public function update(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/brand-logos')->with('error', 'Logo introuvable.');
        }

        if (! $this->validate(['filename' => 'required|max_length[255]', 'name' => 'required|max_length[255]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, $this->baseData());
        $this->logActivity('update', 'brand_logo', $id);

        return redirect()->to('admin/brand-logos')->with('success', 'Logo mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/brand-logos')->with('error', 'Logo introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'brand_logo', $id);

        return redirect()->to('admin/brand-logos')->with('success', 'Logo supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        return [
            'filename'   => $this->request->getPost('filename'),
            'name'       => $this->request->getPost('name'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active'  => (int) ($this->request->getPost('is_active') ?? 0),
        ];
    }
}
