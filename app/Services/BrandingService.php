<?php

namespace App\Services;

use App\Libraries\DbGuard;
use App\Models\MediaModel;
use App\Models\SiteBrandingModel;

class BrandingService
{
    protected SiteBrandingModel $brandingModel;
    protected MediaModel $mediaModel;
    protected MediaService $mediaService;

    public function __construct(
        ?SiteBrandingModel $brandingModel = null,
        ?MediaModel $mediaModel = null,
        ?MediaService $mediaService = null,
    ) {
        $this->brandingModel = $brandingModel ?? model(SiteBrandingModel::class);
        $this->mediaModel    = $mediaModel ?? model(MediaModel::class);
        $this->mediaService  = $mediaService ?? service('media');
    }

    /**
     * @return array<string, string|null>
     */
    public function getBranding(): array
    {
        return DbGuard::run(function () {
            $row = $this->brandingModel->orderBy('id', 'DESC')->first() ?? [];

            $favicon = $this->mediaUrl($row['favicon_id'] ?? null);

            return [
                'logo_light'       => $this->mediaUrl($row['logo_light_id'] ?? null),
                'logo_dark'        => $this->mediaUrl($row['logo_dark_id'] ?? null),
                'logo_mobile'      => $this->mediaUrl($row['logo_mobile_id'] ?? null),
                'favicon'          => $favicon,
                'apple_touch_icon' => $this->mediaUrl($row['apple_touch_icon_id'] ?? null),
                'og_default_image' => $this->mediaUrl($row['og_default_image_id'] ?? null),
                'admin_logo'       => $this->mediaUrl($row['admin_logo_id'] ?? null),
                'admin_favicon'    => $this->mediaUrl($row['admin_favicon_id'] ?? null) ?? $favicon,
            ];
        }, [
            'logo_light' => null, 'logo_dark' => null, 'logo_mobile' => null,
            'favicon' => null, 'apple_touch_icon' => null, 'og_default_image' => null,
            'admin_logo' => null, 'admin_favicon' => null,
        ]);
    }

    public function getLogoLight(): ?string
    {
        return $this->getBranding()['logo_light'];
    }

    public function getLogoDark(): ?string
    {
        return $this->getBranding()['logo_dark'];
    }

    public function getFavicon(): ?string
    {
        return $this->getBranding()['favicon'];
    }

    public function getAdminLogo(): ?string
    {
        return $this->getBranding()['admin_logo'];
    }

    public function getAdminFavicon(): ?string
    {
        return $this->getBranding()['admin_favicon'];
    }

    protected function mediaUrl(int|string|null $mediaId): ?string
    {
        if ($mediaId === null || $mediaId === '' || (int) $mediaId <= 0) {
            return null;
        }

        return $this->mediaService->getUrl((int) $mediaId);
    }
}
