<?php

namespace App\Controllers\Admin;

class SettingsController extends BaseAdminController
{
    protected string $pageTitle  = 'Paramètres';
    protected string $activeMenu = 'settings';

    /** @var list<string> */
    protected array $keys = [
        'admin_email', 'contact_phone', 'contact_address',
        'facebook_url', 'linkedin_url', 'youtube_url', 'tiktok_url',
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
        'smtp_encryption', 'smtp_from_email', 'smtp_from_name', 'whatsapp_number',
    ];

    public function index()
    {
        $defaults = array_fill_keys($this->keys, '');
        $settings = $this->loadSettings($this->keys, $defaults);

        return $this->render('admin/settings/index', [
            'settings' => $settings,
            'action'   => site_url('admin/settings'),
        ]);
    }

    public function update()
    {
        if (! auth()->user()?->can('admin.settings') && ! auth()->user()?->inGroup('superadmin')) {
            return redirect()->to('admin')->with('error', 'Permission refusée.');
        }

        $data = [];
        foreach ($this->keys as $key) {
            $data[$key] = (string) ($this->request->getPost($key) ?? '');
        }

        $this->saveSettings($data, 'site');
        $this->logActivity('update', 'settings');

        return redirect()->to('admin/settings')->with('success', 'Paramètres enregistrés.');
    }
}
