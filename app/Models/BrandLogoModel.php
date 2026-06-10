<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandLogoModel extends Model
{
    protected $table            = 'brand_logos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['filename', 'name', 'sort_order', 'is_active'];
    protected $useTimestamps    = false;
}
