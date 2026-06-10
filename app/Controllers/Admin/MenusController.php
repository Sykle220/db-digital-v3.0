<?php

namespace App\Controllers\Admin;

use App\Models\MenuItemModel;
use App\Models\MenuModel;

class MenusController extends BaseAdminController
{
    protected string $pageTitle  = 'Menus';
    protected string $activeMenu = 'menus';

    protected MenuModel $menuModel;
    protected MenuItemModel $itemModel;

    public function __construct()
    {
        $this->menuModel = model(MenuModel::class);
        $this->itemModel = model(MenuItemModel::class);
    }

    public function index()
    {
        return $this->render('admin/menus/index', [
            'menus' => $this->menuModel->findAll(),
        ]);
    }

    public function create()
    {
        return $this->render('admin/menus/form', [
            'menu'   => null,
            'action' => site_url('admin/menus'),
        ]);
    }

    public function store()
    {
        if (! $this->validate([
            'key'  => 'required|is_unique[menus.key]|max_length[50]',
            'name' => 'required|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->menuModel->insert([
            'key'  => $this->request->getPost('key'),
            'name' => $this->request->getPost('name'),
        ], true);

        $this->logActivity('create', 'menu', (int) $id);

        return redirect()->to('admin/menus')->with('success', 'Menu créé.');
    }

    public function edit(int $id)
    {
        $menu = $this->menuModel->find($id);
        if ($menu === null) {
            return redirect()->to('admin/menus')->with('error', 'Menu introuvable.');
        }

        $items = $this->itemModel->where('menu_id', $id)->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $item['labels'] = $this->loadItemLabels((int) $item['id']);
        }
        unset($item);

        return $this->render('admin/menus/edit', [
            'menu'  => $menu,
            'items' => $items,
            'action' => site_url('admin/menus/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $menu = $this->menuModel->find($id);
        if ($menu === null) {
            return redirect()->to('admin/menus')->with('error', 'Menu introuvable.');
        }

        if (! $this->validate([
            'key'  => "required|is_unique[menus.key,id,{$id}]|max_length[50]",
            'name' => 'required|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->menuModel->update($id, [
            'key'  => $this->request->getPost('key'),
            'name' => $this->request->getPost('name'),
        ]);

        $this->syncItems($id);
        $this->logActivity('update', 'menu', $id);

        return redirect()->to('admin/menus/' . $id)->with('success', 'Menu mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->menuModel->find($id) === null) {
            return redirect()->to('admin/menus')->with('error', 'Menu introuvable.');
        }

        $this->itemModel->where('menu_id', $id)->delete();
        $this->menuModel->delete($id);
        $this->logActivity('delete', 'menu', $id);

        return redirect()->to('admin/menus')->with('success', 'Menu supprimé.');
    }

    protected function syncItems(int $menuId): void
    {
        $items = $this->request->getPost('items') ?? [];
        if (! is_array($items)) {
            return;
        }

        $existingIds = array_column(
            $this->itemModel->where('menu_id', $menuId)->findAll(),
            'id',
        );
        $keptIds = [];

        foreach ($items as $row) {
            if (! is_array($row)) {
                continue;
            }

            $data = [
                'menu_id'      => $menuId,
                'parent_id'    => ! empty($row['parent_id']) ? (int) $row['parent_id'] : null,
                'sort_order'   => (int) ($row['sort_order'] ?? 0),
                'type'         => $row['type'] ?? 'url',
                'target_id'    => ! empty($row['target_id']) ? (int) $row['target_id'] : null,
                'url'          => $row['url'] ?? null,
                'icon'         => $row['icon'] ?? null,
                'css_class'    => $row['css_class'] ?? null,
                'is_active'    => (int) ($row['is_active'] ?? 1),
                'open_new_tab' => (int) ($row['open_new_tab'] ?? 0),
            ];

            $itemId = ! empty($row['id']) ? (int) $row['id'] : 0;
            if ($itemId > 0 && in_array($itemId, $existingIds, true)) {
                $this->itemModel->update($itemId, $data);
                $keptIds[] = $itemId;
            } else {
                $itemId = (int) $this->itemModel->insert($data, true);
                $keptIds[] = $itemId;
            }

            $this->saveItemLabels($itemId, $row['labels'] ?? []);
        }

        foreach (array_diff($existingIds, $keptIds) as $removeId) {
            $this->itemModel->delete($removeId);
        }
    }

    /**
     * @return array<string, string>
     */
    protected function loadItemLabels(int $itemId): array
    {
        $labels = ['fr' => '', 'en' => ''];
        if (! $this->itemModel->db->tableExists('menu_item_translations')) {
            return $labels;
        }

        $rows = $this->itemModel->db->table('menu_item_translations')
            ->where('menu_item_id', $itemId)
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $labels[(string) $row['locale']] = (string) ($row['label'] ?? '');
        }

        return $labels;
    }

    /**
     * @param array<string, mixed> $labels
     */
    protected function saveItemLabels(int $itemId, array $labels): void
    {
        if (! $this->itemModel->db->tableExists('menu_item_translations')) {
            return;
        }

        $db = $this->itemModel->db;
        foreach ($this->locales() as $locale) {
            $label = (string) ($labels[$locale] ?? '');
            $existing = $db->table('menu_item_translations')
                ->where('menu_item_id', $itemId)
                ->where('locale', $locale)
                ->get()
                ->getRowArray();

            if ($existing !== null) {
                $db->table('menu_item_translations')->where('id', $existing['id'])->update(['label' => $label]);
            } else {
                $db->table('menu_item_translations')->insert([
                    'menu_item_id' => $itemId,
                    'locale'       => $locale,
                    'label'        => $label,
                ]);
            }
        }
    }
}
