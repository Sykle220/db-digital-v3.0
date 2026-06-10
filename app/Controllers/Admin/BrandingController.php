<?php

namespace App\Controllers\Admin;

use App\Models\SiteBrandingModel;
use App\Services\BrandingService;

class BrandingController extends BaseAdminController
{
    protected string $pageTitle  = 'Branding';
    protected string $activeMenu = 'branding';

    protected SiteBrandingModel $brandingModel;
    protected BrandingService $brandingService;

    public function __construct()
    {
        $this->brandingModel   = model(SiteBrandingModel::class);
        $this->brandingService = service('branding');
    }

    public function index()
    {
        $branding = $this->brandingModel->orderBy('id', 'DESC')->first() ?? [];

        return $this->render('admin/branding/index', [
            'branding' => $branding,
            'urls'     => $this->brandingService->getBranding(),
        ]);
    }

    public function update()
    {
        $data = [
            'logo_light_id'       => (int) ($this->request->getPost('logo_light_id') ?? 0) ?: null,
            'logo_dark_id'        => (int) ($this->request->getPost('logo_dark_id') ?? 0) ?: null,
            'logo_mobile_id'      => (int) ($this->request->getPost('logo_mobile_id') ?? 0) ?: null,
            'favicon_id'          => (int) ($this->request->getPost('favicon_id') ?? 0) ?: null,
            'apple_touch_icon_id' => (int) ($this->request->getPost('apple_touch_icon_id') ?? 0) ?: null,
            'og_default_image_id' => (int) ($this->request->getPost('og_default_image_id') ?? 0) ?: null,
            'admin_logo_id'       => (int) ($this->request->getPost('admin_logo_id') ?? 0) ?: null,
            'admin_favicon_id'    => (int) ($this->request->getPost('admin_favicon_id') ?? 0) ?: null,
            'updated_at'          => date('Y-m-d H:i:s'),
        ];

        $existing = $this->brandingModel->orderBy('id', 'DESC')->first();
        if ($existing !== null) {
            $this->brandingModel->update($existing['id'], $data);
        } else {
            $this->brandingModel->insert($data);
        }

        $this->logActivity('update', 'branding');

        return redirect()->to('admin/branding')->with('success', 'Branding mis à jour.');
    }
}
