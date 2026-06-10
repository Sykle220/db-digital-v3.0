<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeLocationModel extends Model
{
    protected $table            = 'office_locations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'email', 'phone', 'lat', 'lng', 'image', 'sort_order', 'is_active',
    ];
    protected $useTimestamps = false;
}
