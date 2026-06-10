<?php

namespace App\Models;

use CodeIgniter\Model;

class SeoMetaModel extends Model
{
    protected $table            = 'seo_meta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'entity_type', 'entity_id', 'locale', 'meta_title', 'meta_description',
        'meta_keywords', 'og_title', 'og_description', 'og_image_id',
        'canonical_url', 'robots', 'schema_json',
    ];
    protected $useTimestamps = false;
}
