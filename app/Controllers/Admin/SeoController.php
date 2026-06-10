<?php

namespace App\Controllers\Admin;

use App\Models\SeoMetaModel;
use App\Models\SeoRedirectModel;
use App\Services\SeoService;

class SeoController extends BaseAdminController
{
    protected string $pageTitle  = 'SEO';
    protected string $activeMenu = 'seo';

    protected SeoMetaModel $metaModel;
    protected SeoRedirectModel $redirectModel;
    protected SeoService $seoService;

    public function __construct()
    {
        $this->metaModel      = model(SeoMetaModel::class);
        $this->redirectModel  = model(SeoRedirectModel::class);
        $this->seoService     = service('seo');
    }

    public function index()
    {
        $metaRows = $this->metaModel
            ->orderBy('entity_type', 'ASC')
            ->orderBy('entity_id', 'ASC')
            ->orderBy('locale', 'ASC')
            ->findAll(200);

        return $this->render('admin/seo/index', [
            'redirects' => $this->redirectModel->orderBy('id', 'DESC')->findAll(),
            'metaRows'  => $metaRows,
            'sitemap'   => $this->loadSettings(
                ['sitemap_enabled', 'sitemap_changefreq', 'sitemap_priority'],
                ['sitemap_enabled' => '1', 'sitemap_changefreq' => 'weekly', 'sitemap_priority' => '0.8'],
            ),
        ]);
    }

    public function meta()
    {
        $entityType = (string) ($this->request->getGet('entity_type') ?? 'page');
        $entityId   = (int) ($this->request->getGet('entity_id') ?? 0);
        $locale     = (string) ($this->request->getGet('locale') ?? 'fr');

        $meta = $entityId > 0
            ? ($this->seoService->getMeta($entityType, $entityId, $locale) ?? [])
            : [];

        return $this->render('admin/seo/meta', [
            'entityType' => $entityType,
            'entityId'   => $entityId,
            'locale'     => $locale,
            'meta'       => $meta,
            'action'     => site_url('admin/seo/meta'),
        ]);
    }

    public function saveMeta()
    {
        $entityType = (string) $this->request->getPost('entity_type');
        $entityId   = (int) $this->request->getPost('entity_id');
        $locale     = (string) $this->request->getPost('locale');

        if ($entityId <= 0 || $entityType === '') {
            return redirect()->back()->with('error', 'Entité invalide.');
        }

        $data = [
            'entity_type'       => $entityType,
            'entity_id'         => $entityId,
            'locale'            => $locale,
            'meta_title'        => $this->request->getPost('meta_title'),
            'meta_description'  => $this->request->getPost('meta_description'),
            'meta_keywords'     => $this->request->getPost('meta_keywords'),
            'og_title'          => $this->request->getPost('og_title'),
            'og_description'    => $this->request->getPost('og_description'),
            'og_image_id'       => (int) ($this->request->getPost('og_image_id') ?? 0) ?: null,
            'canonical_url'     => $this->request->getPost('canonical_url'),
            'robots'            => $this->request->getPost('robots'),
            'schema_json'       => $this->request->getPost('schema_json'),
        ];

        $existing = $this->metaModel
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('locale', $locale)
            ->first();

        if ($existing !== null) {
            $this->metaModel->update($existing['id'], $data);
        } else {
            $this->metaModel->insert($data);
        }

        $this->logActivity('update', 'seo_meta', $entityId, $entityType . '/' . $locale);

        return redirect()->back()->with('success', 'Méta SEO enregistrées.');
    }

    public function createRedirect()
    {
        return $this->render('admin/seo/redirect-form', [
            'redirect' => null,
            'action'   => site_url('admin/seo/redirects'),
        ]);
    }

    public function storeRedirect()
    {
        if (! $this->validate([
            'from_path'   => 'required|max_length[500]',
            'to_path'     => 'required|max_length[500]',
            'status_code' => 'required|in_list[301,302,307,308]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->redirectModel->insert([
            'from_path'   => $this->request->getPost('from_path'),
            'to_path'     => $this->request->getPost('to_path'),
            'status_code' => (int) $this->request->getPost('status_code'),
            'is_active'   => (int) ($this->request->getPost('is_active') ?? 1),
            'created_at'  => date('Y-m-d H:i:s'),
        ], true);

        $this->logActivity('create', 'seo_redirect', (int) $id);

        return redirect()->to('admin/seo')->with('success', 'Redirection créée.');
    }

    public function editRedirect(int $id)
    {
        $redirect = $this->redirectModel->find($id);
        if ($redirect === null) {
            return redirect()->to('admin/seo')->with('error', 'Redirection introuvable.');
        }

        return $this->render('admin/seo/redirect-form', [
            'redirect' => $redirect,
            'action'   => site_url('admin/seo/redirects/' . $id),
        ]);
    }

    public function updateRedirect(int $id)
    {
        if ($this->redirectModel->find($id) === null) {
            return redirect()->to('admin/seo')->with('error', 'Redirection introuvable.');
        }

        if (! $this->validate([
            'from_path'   => 'required|max_length[500]',
            'to_path'     => 'required|max_length[500]',
            'status_code' => 'required|in_list[301,302,307,308]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->redirectModel->update($id, [
            'from_path'   => $this->request->getPost('from_path'),
            'to_path'     => $this->request->getPost('to_path'),
            'status_code' => (int) $this->request->getPost('status_code'),
            'is_active'   => (int) ($this->request->getPost('is_active') ?? 1),
        ]);

        $this->logActivity('update', 'seo_redirect', $id);

        return redirect()->to('admin/seo')->with('success', 'Redirection mise à jour.');
    }

    public function deleteRedirect(int $id)
    {
        if ($this->redirectModel->find($id) === null) {
            return redirect()->to('admin/seo')->with('error', 'Redirection introuvable.');
        }

        $this->redirectModel->delete($id);
        $this->logActivity('delete', 'seo_redirect', $id);

        return redirect()->to('admin/seo')->with('success', 'Redirection supprimée.');
    }

    public function saveSitemap()
    {
        $this->saveSettings([
            'sitemap_enabled'    => (string) ($this->request->getPost('sitemap_enabled') ?? '0'),
            'sitemap_changefreq' => (string) $this->request->getPost('sitemap_changefreq'),
            'sitemap_priority'   => (string) $this->request->getPost('sitemap_priority'),
        ], 'seo');

        $this->logActivity('update', 'sitemap_config');

        return redirect()->to('admin/seo')->with('success', 'Configuration sitemap enregistrée.');
    }
}
