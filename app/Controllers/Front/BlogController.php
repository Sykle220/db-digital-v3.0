<?php

namespace App\Controllers\Front;

class BlogController extends BaseFrontController
{
    public function index()
    {
        $content = service('content');
        $posts   = $content->getBlogPosts($this->locale);

        $category = trim((string) $this->request->getGet('category'));
        $tag      = trim((string) $this->request->getGet('tag'));
        $search   = trim((string) $this->request->getGet('search'));

        if ($category !== '') {
            $posts = array_values(array_filter($posts, static fn (array $p): bool => ($p['category'] ?? '') === $category));
        }

        if ($tag !== '') {
            $tagLower = strtolower($tag);
            $posts = array_values(array_filter($posts, static function (array $p) use ($tagLower): bool {
                $haystack = strtolower(
                    ($p['category'] ?? '') . ' ' .
                    ($p['title'] ?? '') . ' ' .
                    ($p['excerpt'] ?? '')
                );

                return str_contains($haystack, $tagLower);
            }));
        }

        if ($search !== '') {
            $searchLower = strtolower($search);
            $posts = array_values(array_filter($posts, static function (array $p) use ($searchLower): bool {
                $haystack = strtolower(($p['title'] ?? '') . ' ' . ($p['excerpt'] ?? ''));

                return str_contains($haystack, $searchLower);
            }));
        }

        return $this->render('front/blog/index', [
            'isHome'          => false,
            'pageTitle'       => site_trans('blog_page_title', $this->locale),
            'pageDescription' => site_trans('blog_page_description', $this->locale),
            'breadcrumbTitle' => site_trans('breadcrumb_blog', $this->locale),
            'seoEntityType'   => 'blog',
            'seoEntityId'     => 1,
            'canonical'       => page_url('blog', $this->locale),
            'posts'           => $posts,
            'categories'      => $content->getBlogCategories($this->locale),
            'tags'            => $content->getBlogTags($this->locale),
            'recentPosts'     => array_slice($content->getBlogPosts($this->locale), 0, 4),
            'filterCategory'  => $category,
            'filterTag'       => $tag,
            'filterSearch'    => $search,
        ]);
    }

    public function show(string $slug)
    {
        $content = service('content');
        $post    = $content->getBlogPostBySlug($slug, $this->locale);

        if ($post === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $postUrl = page_url('blog', $this->locale) . '/' . rawurlencode((string) ($post['slug'] ?? ''));
        $post['url'] = $postUrl;

        $image = (string) ($post['image'] ?? '');
        $ogImage = $image !== '' ? asset_url('img/blog/' . ltrim($image, '/')) : null;

        return $this->render('front/blog/show', [
            'isHome'          => false,
            'pageTitle'       => (string) ($post['title'] ?? site_trans('blog_page_title', $this->locale)),
            'pageDescription' => (string) ($post['excerpt'] ?? site_trans('blog_page_description', $this->locale)),
            'breadcrumbTitle' => (string) ($post['title'] ?? ''),
            'seoEntityType'   => 'blog_post',
            'seoEntityId'     => (int) ($post['id'] ?? 0),
            'ogType'          => 'article',
            'ogImage'         => $ogImage,
            'canonical'       => $postUrl,
            'seoSchemas'      => [
                service('schema')->article($post, $this->locale),
                service('schema')->breadcrumbList([
                    ['label' => site_trans('nav_home', $this->locale), 'url' => page_url('home', $this->locale)],
                    ['label' => site_trans('breadcrumb_blog', $this->locale), 'url' => page_url('blog', $this->locale)],
                    ['label' => (string) ($post['title'] ?? '')],
                ]),
            ],
            'post'            => $post,
            'categories'      => $content->getBlogCategories($this->locale),
            'tags'            => $content->getBlogTags($this->locale),
            'recentPosts'     => array_slice($content->getBlogPosts($this->locale), 0, 4),
        ]);
    }
}
