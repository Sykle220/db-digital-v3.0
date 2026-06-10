<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteBrandingModel extends Model
{
    protected $table            = 'site_branding';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'logo_light_id', 'logo_dark_id', 'logo_mobile_id', 'favicon_id',
        'apple_touch_icon_id', 'og_default_image_id',
        'admin_logo_id', 'admin_favicon_id',
        'updated_at',
    ];
    protected $useTimestamps = false;
}
