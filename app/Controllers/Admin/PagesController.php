<?php

namespace App\Controllers\Admin;

use App\Models\PageModel;

class PagesController extends BaseAdminController
{
    protected string $pageTitle  = 'Pages';
    protected string $activeMenu = 'pages';

    protected PageModel $pageModel;

    /** @var list<string> */
    protected array $translationFields = ['title', 'slug', 'content', 'excerpt'];

    public function __construct()
    {
        $this->pageModel = model(PageModel::class);
    }

    public function index()
    {
        $pages = $this->pageModel->orderBy('sort_order', 'ASC')->findAll();

        foreach ($pages as &$page) {
            $tr = $this->loadTranslations('page_translations', 'page_id', (int) $page['id'], ['title']);
            $page['title_fr'] = $tr['fr']['title'] ?? '';
            $page['title_en'] = $tr['en']['title'] ?? '';
        }
        unset($page);

        return $this->render('admin/pages/index', ['pages' => $pages]);
    }

    public function create()
    {
        return $this->render('admin/pages/form', [
            'page'         => null,
            'translations' => $this->emptyTranslations(),
            'action'       => site_url('admin/pages'),
        ]);
    }

    public function store()
    {
        $rules = [
            'template'     => 'required|max_length[100]',
            'sort_order'   => 'permit_empty|integer',
            'is_published' => 'permit_empty|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->pageModel->insert([
            'template'     => $this->request->getPost('template'),
            'sort_order'   => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_published' => (int) ($this->request->getPost('is_published') ?? 0),
            'published_at' => $this->request->getPost('is_published') ? date('Y-m-d H:i:s') : null,
            'created_by'   => auth()->id(),
        ], true);

        $this->saveTranslations('page_translations', 'page_id', (int) $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('create', 'page', (int) $id);

        return redirect()->to('admin/pages')->with('success', 'Page créée avec succès.');
    }

    public function edit(int $id)
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('admin/pages')->with('error', 'Page introuvable.');
        }

        return $this->render('admin/pages/form', [
            'page'         => $page,
            'translations' => $this->loadTranslations('page_translations', 'page_id', $id, $this->translationFields),
            'action'       => site_url('admin/pages/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('admin/pages')->with('error', 'Page introuvable.');
        }

        if (! $this->validate([
            'template'     => 'required|max_length[100]',
            'sort_order'   => 'permit_empty|integer',
            'is_published' => 'permit_empty|in_list[0,1]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $isPublished = (int) ($this->request->getPost('is_published') ?? 0);
        $this->pageModel->update($id, [
            'template'     => $this->request->getPost('template'),
            'sort_order'   => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_published' => $isPublished,
            'published_at' => $isPublished && empty($page['published_at']) ? date('Y-m-d H:i:s') : $page['published_at'],
        ]);

        $this->saveTranslations('page_translations', 'page_id', $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('update', 'page', $id);

        return redirect()->to('admin/pages')->with('success', 'Page mise à jour.');
    }

    public function delete(int $id)
    {
        $page = $this->pageModel->find($id);
        if ($page === null) {
            return redirect()->to('admin/pages')->with('error', 'Page introuvable.');
        }

        $this->pageModel->delete($id);
        $this->logActivity('delete', 'page', $id);

        return redirect()->to('admin/pages')->with('success', 'Page supprimée.');
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
