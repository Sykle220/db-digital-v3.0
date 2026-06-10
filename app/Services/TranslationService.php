<?php

namespace App\Services;

use App\Libraries\DbGuard;
use App\Models\TranslationKeyModel;
use CodeIgniter\Cache\CacheInterface;

class TranslationService
{
    protected TranslationKeyModel $keyModel;
    protected CacheInterface $cache;
    protected int $cacheTtl = 3600;

    public function __construct(?TranslationKeyModel $keyModel = null, ?CacheInterface $cache = null)
    {
        $this->keyModel = $keyModel ?? model(TranslationKeyModel::class);
        $this->cache    = $cache ?? cache();
    }

    /**
     * Récupère une traduction UI par clé.
     */
    public function get(string $key, ?string $locale = null): string
    {
        $locale       = $this->resolveLocale($locale);
        $translations = $this->loadLocale($locale);

        if (isset($translations[$key]) && $translations[$key] !== '') {
            return $translations[$key];
        }

        return $this->fallbackFromLangFile($key, $locale);
    }

    /**
     * Charge toutes les traductions d'une locale (cache fichier + DB).
     *
     * @return array<string, string>
     */
    public function loadLocale(string $locale): array
    {
        $locale   = $this->resolveLocale($locale);
        $cacheKey = 'site_translations_' . $locale;

        $cached = $this->cache->get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }

        $translations = $this->loadFromDatabase($locale);

        if ($translations === []) {
            $translations = $this->loadLangFile($locale);
        }

        $this->cache->save($cacheKey, $translations, $this->cacheTtl);

        return $translations;
    }

    public function clearCache(?string $locale = null): void
    {
        if ($locale !== null) {
            $this->cache->delete('site_translations_' . $this->resolveLocale($locale));

            return;
        }

        foreach ($this->supportedLocales() as $loc) {
            $this->cache->delete('site_translations_' . $loc);
        }
    }

    /**
     * @return array<string, string>
     */
    protected function loadFromDatabase(string $locale): array
    {
        return DbGuard::run(function () use ($locale) {
            if (! $this->keyModel->db->tableExists('translation_keys')) {
                return [];
            }

            $rows = $this->keyModel->db->table('translation_keys tk')
                ->select('tk.key, tv.value')
                ->join('translation_values tv', 'tv.key_id = tk.id', 'left')
                ->where('tv.locale', $locale)
                ->get()
                ->getResultArray();

            $translations = [];
            foreach ($rows as $row) {
                if (! empty($row['key'])) {
                    $translations[$row['key']] = (string) ($row['value'] ?? '');
                }
            }

            return $translations;
        }, []);
    }

    /**
     * @return array<string, string>
     */
    protected function loadLangFile(string $locale): array
    {
        $path = APPPATH . 'Language/' . $locale . '/App.php';

        if (! is_file($path)) {
            return [];
        }

        $lang = [];
        include $path;

        return is_array($lang) ? $lang : [];
    }

    protected function fallbackFromLangFile(string $key, string $locale): string
    {
        $fileTranslations = $this->loadLangFile($locale);

        if (isset($fileTranslations[$key]) && $fileTranslations[$key] !== '') {
            return $fileTranslations[$key];
        }

        $defaultLocale = config('App')->defaultLocale;
        if ($locale !== $defaultLocale) {
            $defaultTranslations = $this->loadLangFile($defaultLocale);
            if (isset($defaultTranslations[$key])) {
                return $defaultTranslations[$key];
            }
        }

        $line = lang('App.' . $key, [], $locale);
        if ($line !== 'App.' . $key) {
            return $line;
        }

        return $key;
    }

    protected function resolveLocale(?string $locale): string
    {
        if ($locale !== null && in_array($locale, $this->supportedLocales(), true)) {
            return $locale;
        }

        if (function_exists('service') && service('request')) {
            $requestLocale = service('request')->getLocale();
            if (in_array($requestLocale, $this->supportedLocales(), true)) {
                return $requestLocale;
            }
        }

        return config('App')->defaultLocale;
    }

    /**
     * @return list<string>
     */
    protected function supportedLocales(): array
    {
        $locales = config('App')->supportedLocales;

        return $locales !== [] ? $locales : ['fr', 'en'];
    }
}
