<?php

/**
 * Helpers URL, traductions et champs multilingues du site public.
 */

use App\Services\TranslationService;

if (! function_exists('site_trans')) {
    function site_trans(string $key, ?string $locale = null): string
    {
        /** @var TranslationService $service */
        $service = service('translation');

        return $service->get($key, $locale);
    }
}

if (! function_exists('lang_field')) {
    /**
     * @param array<string, mixed> $entity
     */
    function lang_field(array $entity, string $field, ?string $locale = null): string
    {
        $locale = $locale ?? service('request')->getLocale();

        if (isset($entity['translation']) && is_array($entity['translation']) && isset($entity['translation'][$field])) {
            return (string) $entity['translation'][$field];
        }

        if (isset($entity[$field . '_' . $locale])) {
            return (string) $entity[$field . '_' . $locale];
        }

        if (isset($entity[$field])) {
            return (string) $entity[$field];
        }

        $fallback = $locale === 'fr' ? 'en' : 'fr';

        return (string) ($entity[$field . '_' . $fallback] ?? '');
    }
}

if (! function_exists('page_url')) {
    function page_url(string $route, ?string $locale = null): string
    {
        helper('url');

        $locale = $locale ?? service('request')->getLocale();
        if (! in_array($locale, ['fr', 'en'], true)) {
            $locale = config('App')->defaultLocale;
        }

        $routesByLocale = [
            'fr' => [
                'home'             => '',
                'about'            => 'a-propos',
                'services'         => 'services',
                'services-details' => 'services',
                'projects'         => 'projets',
                'contact'          => 'contact',
                'blog'             => 'blog',
                'get-quote'        => 'devis',
            ],
            'en' => [
                'home'             => '',
                'about'            => 'about',
                'services'         => 'services',
                'services-details' => 'services',
                'projects'         => 'projects',
                'contact'          => 'contact',
                'blog'             => 'blog',
                'get-quote'        => 'get-quote',
            ],
        ];

        $routes = $routesByLocale[$locale] ?? $routesByLocale['en'];
        $slug     = $routes[$route] ?? $route;
        $segments = [$locale];

        if ($slug !== '') {
            $segments[] = $slug;
        }

        return site_url(implode('/', $segments));
    }
}

if (! function_exists('quote_submit_url')) {
    function quote_submit_url(?string $locale = null): string
    {
        return rtrim(page_url('get-quote', $locale), '/') . '/submit';
    }
}

if (! function_exists('build_map_locations')) {
    /**
     * @param list<array<string, mixed>> $locations
     *
     * @return list<array<string, mixed>>
     */
    function build_map_locations(array $locations, ?string $locale = null): array
    {
        $locale = $locale ?? service('request')->getLocale();
        $result = [];

        foreach ($locations as $loc) {
            $city = (string) ($loc['city'] ?? '');
            $key  = (string) ($loc['key'] ?? '');
            if ($key === '' && ! empty($loc['email'])) {
                $key = (string) strstr((string) $loc['email'], '@', true);
            }
            if ($key === '' && $city !== '') {
                $slug = strtolower($city);
                $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
                if (is_string($ascii) && $ascii !== '') {
                    $slug = strtolower($ascii);
                }
                $key = trim(preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug, '-');
            }

            $image = (string) ($loc['image_url'] ?? $loc['image'] ?? '');
            if ($image !== '' && ! preg_match('#^https?://#i', $image)) {
                $image = asset_url('img/images/' . ltrim($image, '/'));
            }

            $label = (string) ($loc['label'] ?? '');
            if ($label === '') {
                $label = $locale === 'fr'
                    ? (string) ($loc['label_fr'] ?? $loc['label_en'] ?? '')
                    : (string) ($loc['label_en'] ?? $loc['label_fr'] ?? '');
            }

            $result[] = [
                'key'     => $key,
                'city'    => $city,
                'label'   => $label,
                'address' => (string) ($loc['address'] ?? ''),
                'phone'   => (string) ($loc['phone'] ?? ''),
                'email'   => (string) ($loc['email'] ?? ''),
                'lat'     => (float) ($loc['lat'] ?? 0),
                'lng'     => (float) ($loc['lng'] ?? 0),
                'zoom'    => (int) ($loc['zoom'] ?? 14),
                'image'   => $image,
                'badge'   => (string) ($loc['badge'] ?? site_trans('locations_badge', $locale)),
            ];
        }

        return $result;
    }
}

if (! function_exists('assets_use_minified')) {
    function assets_use_minified(): bool
    {
        $setting = '0';
        if (function_exists('service')) {
            $setting = service('siteSettings')->get('assets_minified', '0');
        }

        $env = env('ASSETS_MINIFIED');
        if ($env !== null && $env !== '') {
            return filter_var($env, FILTER_VALIDATE_BOOLEAN);
        }

        if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
            return filter_var($setting !== '' ? $setting : '1', FILTER_VALIDATE_BOOLEAN);
        }

        return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
    }
}

if (! function_exists('asset_build_manifest')) {
    /**
     * @return array{files?: array<string, string>, hashes?: array<string, string>}|null
     */
    function asset_build_manifest(): ?array
    {
        static $manifest = null;
        static $loaded   = false;

        if ($loaded) {
            return $manifest;
        }

        $loaded = true;
        $file   = ROOTPATH . 'assets/build/manifest.json';

        if (! is_file($file)) {
            $manifest = null;

            return null;
        }

        $data = json_decode((string) file_get_contents($file), true);

        $manifest = is_array($data) ? $data : null;

        return $manifest;
    }
}

if (! function_exists('asset_resolve_path')) {
    function asset_resolve_path(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        if (! assets_use_minified()) {
            return $path;
        }

        $manifest = asset_build_manifest();
        if ($manifest === null || empty($manifest['files'][$path])) {
            return $path;
        }

        return ltrim((string) $manifest['files'][$path], '/');
    }
}

if (! function_exists('asset_version')) {
    function asset_version(string $path): ?string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $manifest = asset_build_manifest();

        if ($manifest !== null && ! empty($manifest['hashes'][$path])) {
            return (string) $manifest['hashes'][$path];
        }

        $fs = ROOTPATH . 'assets/' . asset_resolve_path($path);
        if (is_file($fs)) {
            $mtime = filemtime($fs);

            return $mtime !== false ? (string) $mtime : null;
        }

        $src = ROOTPATH . 'assets/' . $path;
        if (is_file($src)) {
            $mtime = filemtime($src);

            return $mtime !== false ? (string) $mtime : null;
        }

        return null;
    }
}

if (! function_exists('asset_url')) {
    function asset_url(string $path, bool $withVersion = false): string
    {
        helper('url');

        $sourcePath = ltrim(str_replace('\\', '/', $path), '/');
        $resolved   = asset_resolve_path($sourcePath);
        $fullPath   = 'assets/' . $resolved;
        $cdn        = '';

        if (function_exists('service')) {
            $cdn = service('siteSettings')->get('cdn_assets_url', '');
        }

        $url = $cdn !== ''
            ? rtrim($cdn, '/') . '/' . ltrim($fullPath, '/')
            : base_url($fullPath);

        if ($withVersion) {
            $version = asset_version($sourcePath);
            if ($version !== null && $version !== '') {
                $url .= (str_contains($url, '?') ? '&' : '?') . 'v=' . rawurlencode($version);
            }
        }

        return $url;
    }
}

if (! function_exists('responsive_img')) {
    /**
     * Balise img optimisée (lazy loading, dimensions optionnelles).
     *
     * @param array<string, string|int|bool|null> $attrs
     */
    function responsive_img(string $src, string $alt = '', array $attrs = []): string
    {
        $lazyDefault = true;
        if (function_exists('service')) {
            $lazyDefault = service('siteSettings')->integrations()['lazy_images'] ?? true;
        }

        $loading  = ($attrs['loading'] ?? ($lazyDefault ? 'lazy' : 'eager'));
        $decoding = (string) ($attrs['decoding'] ?? 'async');
        $class    = (string) ($attrs['class'] ?? '');
        $srcset   = (string) ($attrs['srcset'] ?? '');
        $sizes    = (string) ($attrs['sizes'] ?? '');
        $width    = $attrs['width'] ?? null;
        $height   = $attrs['height'] ?? null;

        unset($attrs['loading'], $attrs['decoding'], $attrs['class'], $attrs['srcset'], $attrs['sizes'], $attrs['width'], $attrs['height']);

        $extra = '';
        foreach ($attrs as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }
            $extra .= ' ' . esc($key, 'attr') . '="' . esc((string) $value, 'attr') . '"';
        }

        $imgAttrs = ($class !== '' ? ' class="' . esc($class, 'attr') . '"' : '')
            . ' loading="' . esc($loading, 'attr') . '" decoding="' . esc($decoding, 'attr') . '"'
            . ($srcset !== '' ? ' srcset="' . esc($srcset, 'attr') . '"' : '')
            . ($sizes !== '' ? ' sizes="' . esc($sizes, 'attr') . '"' : '')
            . ($width !== null ? ' width="' . esc((string) $width, 'attr') . '"' : '')
            . ($height !== null ? ' height="' . esc((string) $height, 'attr') . '"' : '')
            . $extra;

        $webpSrc = responsive_img_webp_src($src);
        if ($webpSrc !== null) {
            return '<picture>'
                . '<source srcset="' . esc($webpSrc, 'attr') . '" type="image/webp">'
                . '<img src="' . esc($src, 'attr') . '" alt="' . esc($alt, 'attr') . '"' . $imgAttrs . '>'
                . '</picture>';
        }

        return '<img src="' . esc($src, 'attr') . '" alt="' . esc($alt, 'attr') . '"' . $imgAttrs . '>';
    }
}

if (! function_exists('responsive_img_webp_src')) {
    function responsive_img_webp_src(string $src): ?string
    {
        if (! preg_match('/\.(jpe?g|png)$/i', $src)) {
            return null;
        }

        $webpUrl = preg_replace('/\.(jpe?g|png)$/i', '.webp', $src);
        if ($webpUrl === $src) {
            return null;
        }

        $base = rtrim((string) base_url(), '/');
        $path = $src;
        if (str_starts_with($path, $base)) {
            $path = substr($path, strlen($base));
        }

        $fsPath = FCPATH . ltrim($path, '/');
        $webpFs = preg_replace('/\.(jpe?g|png)$/i', '.webp', $fsPath);

        return is_file($webpFs) ? $webpUrl : null;
    }
}

if (! function_exists('upload_url')) {
    function upload_url(string $path): string
    {
        helper('url');

        return base_url('uploads/' . ltrim($path, '/'));
    }
}

if (! function_exists('service_url')) {
    function service_url(string $slug, ?string $locale = null): string
    {
        return rtrim(page_url('services', $locale), '/') . '/' . rawurlencode($slug);
    }
}

if (! function_exists('city_url')) {
    function city_url(string $officeKey, ?string $locale = null): string
    {
        helper('url');

        $locale = $locale ?? service('request')->getLocale();
        $prefix = $locale === 'fr' ? 'agence-digitale' : 'digital-agency';

        return site_url($locale . '/' . $prefix . '/' . rawurlencode($officeKey));
    }
}

if (! function_exists('lang_url')) {
    function lang_url(?string $locale = null): string
    {
        helper('url');

        $locale = $locale ?? service('request')->getLocale();
        if (! in_array($locale, ['fr', 'en'], true)) {
            $locale = config('App')->defaultLocale;
        }

        $skip = ['index.php', 'public', 'dbdigitalagency'];
        $segments = array_values(array_filter(
            service('request')->getUri()->getSegments(),
            static fn (string $segment): bool => ! in_array($segment, $skip, true),
        ));

        if ($segments !== [] && in_array($segments[0], ['fr', 'en'], true)) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        $query = service('request')->getUri()->getQuery();
        $url   = site_url(implode('/', $segments));

        return $query !== '' ? $url . '?' . $query : $url;
    }
}

if (! function_exists('btn_icon')) {
    function btn_icon(string $type): string
    {
        $icons = [
            'home'      => 'fas fa-home',
            'quote'     => 'fas fa-file-invoice',
            'read_more' => 'fas fa-book-open',
            'services'  => 'fas fa-briefcase',
            'projects'  => 'fas fa-folder-open',
            'contact'   => 'fas fa-envelope',
            'subscribe' => 'fas fa-paper-plane',
            'whatsapp'  => 'fab fa-whatsapp',
            'details'   => 'fas fa-arrow-right',
            'send'      => 'fas fa-paper-plane',
        ];
        $class = $icons[$type] ?? 'fas fa-arrow-right';

        return '<i class="' . $class . ' btn-i" aria-hidden="true"></i>';
    }
}

if (! function_exists('social_url')) {
    function social_url(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '#';
        }
        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }

        return $url;
    }
}

if (! function_exists('social_icons_html')) {
    function social_icons_html(?array $links = null, string $class = ''): string
    {
        if ($links === null) {
            $links = [
                'facebook'  => 'https://www.facebook.com/share/18a3vkULiE',
                'tiktok'    => 'https://www.tiktok.com/@db.digital.agency5',
                'youtube'   => 'https://www.youtube.com/@DBdigitalagency',
                'linkedin'  => 'https://www.linkedin.com/company/db-digitalagency-com',
            ];
        }

        $labels = [
            'facebook'  => 'Facebook',
            'tiktok'    => 'TikTok',
            'youtube'   => 'YouTube',
            'linkedin'  => 'LinkedIn',
            'instagram' => 'Instagram',
            'twitter'   => 'X',
            'pinterest' => 'Pinterest',
        ];

        $html = '<ul class="list-wrap ' . esc(trim($class), 'attr') . '">';
        foreach ($links as $network => $url) {
            $icon = match ($network) {
                'facebook'  => 'fa-facebook-f',
                'tiktok'    => 'fa-tiktok',
                'youtube'   => 'fa-youtube',
                'linkedin'  => 'fa-linkedin-in',
                'instagram' => 'fa-instagram',
                'twitter', 'x' => 'fa-x-twitter',
                'pinterest' => 'fa-pinterest-p',
                default     => 'fa-globe',
            };
            $href  = social_url((string) $url);
            $label = $labels[$network] ?? ucfirst((string) $network);
            $html .= '<li><a href="' . esc($href, 'attr') . '" target="_blank" rel="noopener noreferrer"'
                . ' aria-label="' . esc($label, 'attr') . '">'
                . '<i class="fab ' . $icon . '" aria-hidden="true"></i></a></li>';
        }

        return $html . '</ul>';
    }
}

if (! function_exists('is_nav_active')) {
    function is_nav_active(string $url): string
    {
        $current = current_url();
        $target  = strpos($url, 'http') === 0 ? $url : site_url(ltrim($url, '/'));

        return rtrim($current, '/') === rtrim($target, '/') ? 'active' : '';
    }
}

if (! function_exists('project_image_url')) {
    function project_image_url(array $project): string
    {
        $image = (string) ($project['image'] ?? $project['img'] ?? '');
        if ($image === '') {
            return asset_url('img/project/h5_project_img01.jpg');
        }
        if (str_starts_with($image, 'http')) {
            return $image;
        }

        return asset_url('img/project/' . ltrim($image, '/'));
    }
}

if (! function_exists('team_image_url')) {
    function team_image_url(array $member): string
    {
        if (! empty($member['image_url'])) {
            return (string) $member['image_url'];
        }

        $image = (string) ($member['image'] ?? $member['img'] ?? '');
        if ($image === '') {
            return asset_url('img/team/team_img_rose.png');
        }
        if (str_starts_with($image, 'http')) {
            return $image;
        }

        return asset_url('img/team/' . ltrim($image, '/'));
    }
}
