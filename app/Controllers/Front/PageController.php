<?php

namespace App\Controllers\Front;

class PageController extends BaseFrontController
{
    /** @var list<string> */
    private const RESERVED = [
        'about', 'services', 'projects', 'blog', 'contact', 'get-quote', 'sitemap.xml',
    ];

    public function show(string $slug)
    {
        if (in_array($slug, self::RESERVED, true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $page = service('content')->getPageBySlug($slug, $this->locale);

        if ($page === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $template = (string) ($page['template'] ?? '');
        $view     = $template === 'legal' ? 'front/legal' : 'front/page';
        $isPrivacy = in_array((string) ($page['slug'] ?? ''), ['politique-confidentialite', 'privacy-policy'], true);

        $description = (string) ($page['meta_description'] ?? '');
        if ($description === '' && ! empty($page['excerpt'])) {
            $description = (string) $page['excerpt'];
        }

        return $this->render($view, [
            'isHome'          => false,
            'pageTitle'       => (string) ($page['title'] ?? $slug),
            'pageDescription' => $description !== '' ? $description : site_trans('meta_default_description', $this->locale),
            'breadcrumbTitle' => (string) ($page['title'] ?? $slug),
            'seoEntityType'   => 'page',
            'seoEntityId'     => (int) ($page['page_id'] ?? 0),
            'canonical'       => site_url($this->locale . '/' . ltrim((string) ($page['slug'] ?? $slug), '/')),
            'page'            => $page,
            'legalType'       => $isPrivacy ? 'privacy' : 'legal',
        ]);
    }
}
