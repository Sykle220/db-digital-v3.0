<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminActivityModel extends Model
{
    protected $table            = 'admin_activity_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'action', 'entity_type', 'entity_id', 'details', 'ip_address',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}
