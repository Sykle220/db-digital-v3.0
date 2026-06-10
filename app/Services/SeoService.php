<?php

namespace App\Services;

use App\Libraries\DbGuard;
use App\Models\SeoMetaModel;
use App\Models\SeoRedirectModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;

class SeoService
{
    protected SeoMetaModel $metaModel;
    protected SeoRedirectModel $redirectModel;
    protected MediaService $mediaService;

    public function __construct(
        ?SeoMetaModel $metaModel = null,
        ?SeoRedirectModel $redirectModel = null,
        ?MediaService $mediaService = null,
    ) {
        $this->metaModel      = $metaModel ?? model(SeoMetaModel::class);
        $this->redirectModel  = $redirectModel ?? model(SeoRedirectModel::class);
        $this->mediaService   = $mediaService ?? service('media');
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getMeta(string $entityType, int $entityId, ?string $locale = null): ?array
    {
        $locale = $this->resolveLocale($locale);

        $meta = $this->metaModel
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('locale', $locale)
            ->first();

        if ($meta === null) {
            return null;
        }

        if (! empty($meta['og_image_id'])) {
            $meta['og_image_url'] = $this->mediaService->getUrl((int) $meta['og_image_id']);
        }

        return $meta;
    }

    /**
     * @param array<string, mixed> $meta
     */
    public function renderMetaTags(array $meta): string
    {
        $tags = [];

        if (! empty($meta['meta_title'])) {
            $tags[] = '<title>' . esc($meta['meta_title']) . '</title>';
            $tags[] = '<meta name="title" content="' . esc($meta['meta_title'], 'attr') . '">';
        }

        if (! empty($meta['meta_description'])) {
            $tags[] = '<meta name="description" content="' . esc($meta['meta_description'], 'attr') . '">';
        }

        if (! empty($meta['meta_keywords'])) {
            $tags[] = '<meta name="keywords" content="' . esc($meta['meta_keywords'], 'attr') . '">';
        }

        if (! empty($meta['robots'])) {
            $tags[] = '<meta name="robots" content="' . esc($meta['robots'], 'attr') . '">';
        }

        if (! empty($meta['canonical_url'])) {
            $tags[] = '<link rel="canonical" href="' . esc($meta['canonical_url'], 'attr') . '">';
        }

        $ogTitle = $meta['og_title'] ?? $meta['meta_title'] ?? '';
        if ($ogTitle !== '') {
            $tags[] = '<meta property="og:title" content="' . esc($ogTitle, 'attr') . '">';
        }

        $ogDescription = $meta['og_description'] ?? $meta['meta_description'] ?? '';
        if ($ogDescription !== '') {
            $tags[] = '<meta property="og:description" content="' . esc($ogDescription, 'attr') . '">';
        }

        $ogImage = $meta['og_image_url'] ?? null;
        if ($ogImage) {
            $tags[] = '<meta property="og:image" content="' . esc($ogImage, 'attr') . '">';
        }

        if (! empty($meta['schema_json'])) {
            $tags[] = '<script type="application/ld+json">' . $meta['schema_json'] . '</script>';
        }

        return implode("\n", $tags);
    }

    /**
     * Vérifie si une redirection SEO s'applique au chemin courant.
     */
    public function findRedirect(string $path): ?array
    {
        $path = $this->normalizePath($path);

        $legacy = config('LegacyRedirects');
        if (is_array($legacy->map) && isset($legacy->map[$path])) {
            return [
                'from_path'   => $path,
                'to_path'     => $legacy->map[$path],
                'status_code' => 301,
                'is_active'   => 1,
            ];
        }

        if (! DbGuard::available()) {
            return null;
        }

        if (! $this->redirectModel->db->tableExists('seo_redirects')) {
            return null;
        }

        return $this->redirectModel
            ->where('from_path', $path)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Applique une redirection si nécessaire.
     */
    public function checkRedirect(RequestInterface $request): ?RedirectResponse
    {
        $legacyService = $this->legacyServiceRedirect($request);
        if ($legacyService !== null) {
            return $legacyService;
        }

        $path     = $this->normalizePath($request->getPath());
        $redirect = $this->findRedirect($path);

        if ($redirect === null) {
            return null;
        }

        $statusCode = (int) ($redirect['status_code'] ?? 301);
        $toPath     = (string) $redirect['to_path'];

        if (str_starts_with($toPath, 'http://') || str_starts_with($toPath, 'https://')) {
            return redirect()->to($toPath, 'auto', $statusCode);
        }

        return redirect()->to(site_url(ltrim($toPath, '/')), null, $statusCode);
    }

    protected function legacyServiceRedirect(RequestInterface $request): ?RedirectResponse
    {
        $path = $this->normalizePath($request->getPath());
        if (! str_contains($path, 'services-details')) {
            return null;
        }

        $locale = 'fr';
        if (preg_match('#^/(fr|en)(/|$)#', $path, $m)) {
            $locale = $m[1];
        }

        $service = trim((string) ($request->getGet('service') ?? ''));
        if ($service === '') {
            return redirect()->to(site_url($locale . '/services'), null, 301);
        }

        $slug = preg_replace('/[^a-z0-9\-]/i', '', $service) ?? $service;

        return redirect()->to(site_url($locale . '/services/' . rawurlencode($slug)), null, 301);
    }

    protected function normalizePath(string $path): string
    {
        $path = '/' . trim($path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }

    protected function resolveLocale(?string $locale): string
    {
        if ($locale !== null && in_array($locale, ['fr', 'en'], true)) {
            return $locale;
        }

        return service('request')->getLocale();
    }
}
