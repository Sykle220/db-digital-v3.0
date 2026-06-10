<?php

namespace App\Controllers\Admin;

use App\Models\TranslationKeyModel;
use App\Services\TranslationService;

class TranslationsController extends BaseAdminController
{
    protected string $pageTitle  = 'Traductions';
    protected string $activeMenu = 'translations';

    protected TranslationKeyModel $keyModel;
    protected TranslationService $translationService;

    public function __construct()
    {
        $this->keyModel           = model(TranslationKeyModel::class);
        $this->translationService = service('translation');
    }

    public function index()
    {
        $groups = $this->keyModel->db->tableExists('translation_keys')
            ? array_column(
                $this->keyModel->select('group')->distinct()->orderBy('group', 'ASC')->findAll(),
                'group',
            )
            : [];

        $requestedGroup = (string) ($this->request->getGet('group') ?? '');
        $group          = $requestedGroup !== '' && in_array($requestedGroup, $groups, true)
            ? $requestedGroup
            : ($groups[0] ?? 'app');

        $perPage = 20;
        $keys    = $this->keyModel
            ->where('group', $group)
            ->orderBy('key', 'ASC')
            ->paginate($perPage);

        $valuesByKey = $this->loadValuesBatch(array_map(static fn (array $row): int => (int) $row['id'], $keys));
        foreach ($keys as &$key) {
            $key['values'] = $valuesByKey[(int) $key['id']] ?? $this->emptyLocaleValues();
        }
        unset($key);

        $pagerService = $this->keyModel->pager;

        return $this->render('admin/translations/index', [
            'keys'         => $keys,
            'currentGroup' => $group,
            'groups'       => $groups,
            'totalKeys'    => $this->keyModel->db->table('translation_keys')->countAllResults(),
            'groupTotal'   => $pagerService->getTotal(),
            'pager'        => $this->pagerRenderer(),
            'currentPage'  => $pagerService->getCurrentPage(),
            'perPage'      => $perPage,
        ]);
    }

    public function save()
    {
        $group  = (string) ($this->request->getPost('group') ?? 'general');
        $values = $this->request->getPost('values') ?? [];

        if (! is_array($values) || ! $this->keyModel->db->tableExists('translation_values')) {
            return redirect()->back()->with('error', 'Données invalides.');
        }

        $db = $this->keyModel->db;

        foreach ($values as $keyId => $locales) {
            if (! is_array($locales)) {
                continue;
            }

            foreach ($this->locales() as $locale) {
                $value = (string) ($locales[$locale] ?? '');
                $existing = $db->table('translation_values')
                    ->where('key_id', (int) $keyId)
                    ->where('locale', $locale)
                    ->get()
                    ->getRowArray();

                if ($existing !== null) {
                    $db->table('translation_values')->where('id', $existing['id'])->update(['value' => $value]);
                } else {
                    $db->table('translation_values')->insert([
                        'key_id' => (int) $keyId,
                        'locale' => $locale,
                        'value'  => $value,
                    ]);
                }
            }
        }

        $this->translationService->clearCache();
        $this->logActivity('update', 'translations', null, 'Groupe: ' . $group);

        $page = max(1, (int) ($this->request->getPost('page') ?? 1));

        return redirect()->to('admin/translations?group=' . urlencode($group) . '&page=' . $page)
            ->with('success', 'Traductions enregistrées.');
    }

    /**
     * @return array<string, string>
     */
    protected function loadValues(int $keyId): array
    {
        $values = [];
        foreach ($this->locales() as $locale) {
            $values[$locale] = '';
        }

        if (! $this->keyModel->db->tableExists('translation_values')) {
            return $values;
        }

        $rows = $this->keyModel->db->table('translation_values')
            ->where('key_id', $keyId)
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $values[(string) $row['locale']] = (string) ($row['value'] ?? '');
        }

        return $values;
    }

    /**
     * @param list<int> $keyIds
     *
     * @return array<int, array<string, string>>
     */
    protected function loadValuesBatch(array $keyIds): array
    {
        $result = [];
        foreach ($keyIds as $keyId) {
            $result[$keyId] = $this->emptyLocaleValues();
        }

        if ($keyIds === [] || ! $this->keyModel->db->tableExists('translation_values')) {
            return $result;
        }

        $rows = $this->keyModel->db->table('translation_values')
            ->whereIn('key_id', $keyIds)
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $keyId = (int) ($row['key_id'] ?? 0);
            $locale = (string) ($row['locale'] ?? '');
            if (isset($result[$keyId]) && isset($result[$keyId][$locale])) {
                $result[$keyId][$locale] = (string) ($row['value'] ?? '');
            }
        }

        return $result;
    }

    /**
     * @return array<string, string>
     */
    protected function emptyLocaleValues(): array
    {
        $values = [];
        foreach ($this->locales() as $locale) {
            $values[$locale] = '';
        }

        return $values;
    }
}
