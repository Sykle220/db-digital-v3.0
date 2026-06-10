<?php

namespace App\Controllers\Admin;

use App\Models\BlogPostModel;

class BlogController extends BaseAdminController
{
    protected string $pageTitle  = 'Blog';
    protected string $activeMenu = 'blog';

    protected BlogPostModel $model;

    /** @var list<string> */
    protected array $translationFields = ['title', 'excerpt', 'content'];

    public function __construct()
    {
        $this->model = model(BlogPostModel::class);
    }

    public function index()
    {
        $items = $this->model->orderBy('sort_order', 'ASC')->findAll();
        foreach ($items as &$item) {
            $tr = $this->loadTranslations('blog_post_translations', 'post_id', (int) $item['id'], ['title']);
            $item['title_fr'] = $tr['fr']['title'] ?? '';
            $item['title_en'] = $tr['en']['title'] ?? '';
        }
        unset($item);

        return $this->render('admin/blog/index', ['items' => $items]);
    }

    public function create()
    {
        return $this->render('admin/blog/form', [
            'item'         => null,
            'translations' => $this->emptyTranslations(),
            'action'       => site_url('admin/blog'),
        ]);
    }

    public function store()
    {
        if (! $this->validate(['slug' => 'required|is_unique[blog_posts.slug]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $isPublished = (int) ($this->request->getPost('is_published') ?? 0);
        $id = $this->model->insert([
            'slug'         => $this->request->getPost('slug'),
            'image'        => $this->request->getPost('image'),
            'author'       => $this->request->getPost('author'),
            'category_id'  => $this->nullableInt('category_id'),
            'sort_order'   => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? date('Y-m-d H:i:s') : null,
        ], true);

        $this->saveTranslations('blog_post_translations', 'post_id', (int) $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('create', 'blog_post', (int) $id);

        return redirect()->to('admin/blog')->with('success', 'Article créé.');
    }

    public function edit(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/blog')->with('error', 'Article introuvable.');
        }

        return $this->render('admin/blog/form', [
            'item'         => $item,
            'translations' => $this->loadTranslations('blog_post_translations', 'post_id', $id, $this->translationFields),
            'action'       => site_url('admin/blog/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $item = $this->model->find($id);
        if ($item === null) {
            return redirect()->to('admin/blog')->with('error', 'Article introuvable.');
        }

        if (! $this->validate(['slug' => "required|is_unique[blog_posts.slug,id,{$id}]"])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $isPublished = (int) ($this->request->getPost('is_published') ?? 0);
        $this->model->update($id, [
            'slug'         => $this->request->getPost('slug'),
            'image'        => $this->request->getPost('image'),
            'author'       => $this->request->getPost('author'),
            'category_id'  => $this->nullableInt('category_id'),
            'sort_order'   => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_published' => $isPublished,
            'published_at' => $isPublished && empty($item['published_at']) ? date('Y-m-d H:i:s') : $item['published_at'],
        ]);

        $this->saveTranslations('blog_post_translations', 'post_id', $id, $this->request->getPost('translations') ?? [], $this->translationFields);
        $this->logActivity('update', 'blog_post', $id);

        return redirect()->to('admin/blog')->with('success', 'Article mis à jour.');
    }

    public function delete(int $id)
    {
        if ($this->model->find($id) === null) {
            return redirect()->to('admin/blog')->with('error', 'Article introuvable.');
        }

        $this->model->delete($id);
        $this->logActivity('delete', 'blog_post', $id);

        return redirect()->to('admin/blog')->with('success', 'Article supprimé.');
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

    protected function nullableInt(string $field): ?int
    {
        $value = $this->request->getPost($field);

        return ($value === null || $value === '') ? null : (int) $value;
    }
}
