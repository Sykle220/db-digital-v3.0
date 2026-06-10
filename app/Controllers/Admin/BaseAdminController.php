<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminActivityModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Pager\PagerRenderer;
use Psr\Log\LoggerInterface;

abstract class BaseAdminController extends BaseController
{
    protected string $adminLayout = 'admin/layouts/main';
    protected string $pageTitle   = 'Administration';
    protected string $activeMenu  = '';

    protected AdminActivityModel $activityModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);

        $this->helpers       = ['form', 'url', 'site'];
        $this->activityModel = model(AdminActivityModel::class);
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): string
    {
        $data['pageTitle']    = $data['pageTitle'] ?? $this->pageTitle;
        $data['activeMenu']   = $data['activeMenu'] ?? $this->activeMenu;
        $data['currentUser']  = auth()->user();
        $data['isSuperAdmin'] = $data['isSuperAdmin'] ?? $this->isSuperAdmin();

        return view($this->adminLayout, array_merge($data, [
            'content' => view($view, $data),
        ]));
    }

    protected function logActivity(
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?string $details = null,
    ): void {
        if (! $this->activityModel->db->tableExists('admin_activity_log')) {
            return;
        }

        $user = auth()->user();

        $this->activityModel->insert([
            'user_id'     => $user?->id,
            'action'      => $action,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'details'     => $details,
            'ip_address'  => $this->request->getIPAddress(),
        ]);
    }

    /**
     * @return list<string>
     */
    protected function locales(): array
    {
        return config('App')->supportedLocales ?: ['fr', 'en'];
    }

    /**
     * @param list<string> $fields
     * @param array<string, array<string, mixed>> $input
     */
    protected function saveTranslations(
        string $table,
        string $foreignKey,
        int $entityId,
        array $input,
        array $fields,
    ): void {
        if (! $this->activityModel->db->tableExists($table)) {
            return;
        }

        $db = $this->activityModel->db;

        foreach ($this->locales() as $locale) {
            $row = [
                $foreignKey => $entityId,
                'locale'    => $locale,
            ];

            foreach ($fields as $field) {
                $row[$field] = $input[$locale][$field] ?? ($input[$field . '_' . $locale] ?? '');
            }

            $existing = $db->table($table)
                ->where($foreignKey, $entityId)
                ->where('locale', $locale)
                ->get()
                ->getRowArray();

            if ($existing !== null) {
                $db->table($table)->where('id', $existing['id'])->update($row);
            } else {
                $db->table($table)->insert($row);
            }
        }
    }

    /**
     * @param list<string> $fields
     *
     * @return array<string, array<string, mixed>>
     */
    protected function loadTranslations(string $table, string $foreignKey, int $entityId, array $fields): array
    {
        $result = [];
        foreach ($this->locales() as $locale) {
            $result[$locale] = array_fill_keys($fields, '');
        }

        if (! $this->activityModel->db->tableExists($table)) {
            return $result;
        }

        $rows = $this->activityModel->db->table($table)
            ->where($foreignKey, $entityId)
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $locale = (string) ($row['locale'] ?? '');
            if (! isset($result[$locale])) {
                continue;
            }
            foreach ($fields as $field) {
                $result[$locale][$field] = $row[$field] ?? '';
            }
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $settings
     */
    protected function saveSettings(array $settings, string $group = 'general'): void
    {
        $model = model(\App\Models\SettingModel::class);

        foreach ($settings as $key => $value) {
            $existing = $model->where('setting_key', $key)->first();
            $payload  = [
                'setting_key'   => $key,
                'setting_value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) $value,
            ];

            if (in_array('setting_group', $model->allowedFields, true)) {
                $payload['setting_group'] = $group;
            }

            if ($existing !== null) {
                $model->update($existing['id'], $payload);
            } else {
                $model->insert($payload);
            }
        }
    }

    /**
     * @return array<string, string>
     */
    protected function loadSettings(array $keys, array $defaults = []): array
    {
        $model = model(\App\Models\SettingModel::class);
        $out   = $defaults;

        foreach ($keys as $key) {
            $row = $model->where('setting_key', $key)->first();
            if ($row !== null) {
                $out[$key] = (string) ($row['setting_value'] ?? '');
            }
        }

        return $out;
    }

    protected function redirectBack(string $fallback = 'admin'): RedirectResponse
    {
        $back = previous_url();

        return redirect()->to($back !== current_url() ? $back : site_url($fallback));
    }

    protected function isSuperAdmin(): bool
    {
        $user = auth()->user();

        return $user !== null && ($user->inGroup('superadmin') || $user->can('users.manage-admins'));
    }

    /**
     * Retourne le renderer de pagination (méthodes getPerPageStart, links, etc.).
     */
    protected function pagerRenderer(string $group = 'default'): ?PagerRenderer
    {
        try {
            return new PagerRenderer(service('pager')->getDetails($group));
        } catch (\Throwable) {
            return null;
        }
    }
}
