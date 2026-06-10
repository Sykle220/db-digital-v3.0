<?php

namespace App\Models;

use CodeIgniter\Model;

class SeoRedirectModel extends Model
{
    protected $table            = 'seo_redirects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['from_path', 'to_path', 'status_code', 'is_active', 'created_at'];
    protected $useTimestamps    = false;
}
