<?php

namespace App\Controllers\Admin;

class IntegrationsController extends BaseAdminController
{
    protected string $pageTitle  = 'Intégrations';
    protected string $activeMenu = 'integrations';

    /** @var list<string> */
    protected array $keys = [
        'gtm_container_id', 'ga4_measurement_id', 'meta_pixel_id', 'linkedin_partner_id',
        'hotjar_site_id', 'clarity_project_id', 'tracking_enabled',
        'cookie_banner_enabled', 'cookie_policy_text_fr', 'cookie_policy_text_en',
        'privacy_page_slug_fr', 'privacy_page_slug_en',
        'legal_page_slug_fr', 'legal_page_slug_en',
        'recaptcha_enabled', 'recaptcha_site_key',
        'tinymce_api_key',
        'form_rate_limit_max', 'form_rate_limit_minutes',
        'cdn_assets_url', 'defer_scripts', 'lazy_images', 'preload_fonts', 'assets_minified',
    ];

    public function index()
    {
        if (! auth()->user()?->can('admin.settings') && ! auth()->user()?->inGroup('superadmin')) {
            return redirect()->to('admin')->with('error', 'Permission refusée.');
        }

        $defaults = array_fill_keys($this->keys, '');
        $defaults['tracking_enabled']       = '1';
        $defaults['cookie_banner_enabled']  = '1';
        $defaults['form_rate_limit_max']    = '8';
        $defaults['form_rate_limit_minutes']= '15';
        $defaults['defer_scripts']          = '1';
        $defaults['lazy_images']            = '1';
        $defaults['preload_fonts']          = '1';
        $defaults['assets_minified']        = '0';

        $manifestPath = ROOTPATH . 'assets/build/manifest.json';
        $buildInfo    = null;
        if (is_file($manifestPath)) {
            $decoded = json_decode((string) file_get_contents($manifestPath), true);
            if (is_array($decoded)) {
                $buildInfo = [
                    'built_at' => (string) ($decoded['built_at'] ?? ''),
                    'count'    => count($decoded['files'] ?? []),
                ];
            }
        }

        return $this->render('admin/integrations/index', [
            'settings'  => $this->loadSettings($this->keys, $defaults),
            'action'    => site_url('admin/integrations'),
            'buildInfo' => $buildInfo,
        ]);
    }

    public function update()
    {
        if (! auth()->user()?->can('admin.settings') && ! auth()->user()?->inGroup('superadmin')) {
            return redirect()->to('admin')->with('error', 'Permission refusée.');
        }

        $booleans = [
            'tracking_enabled', 'cookie_banner_enabled', 'recaptcha_enabled',
            'defer_scripts', 'lazy_images', 'preload_fonts', 'assets_minified',
        ];

        $data = [];
        foreach ($this->keys as $key) {
            if (in_array($key, $booleans, true)) {
                $data[$key] = $this->request->getPost($key) ? '1' : '0';
            } else {
                $data[$key] = trim((string) ($this->request->getPost($key) ?? ''));
            }
        }

        $this->saveSettings($data, 'integrations');
        service('siteSettings')->clearCache();
        $this->logActivity('update', 'integrations');

        return redirect()->to('admin/integrations')->with('success', 'Intégrations enregistrées.');
    }
}
