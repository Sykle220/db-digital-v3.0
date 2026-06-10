<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamMemberModel extends Model
{
    protected $table            = 'team_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['image', 'sort_order', 'is_active'];
    protected $useTimestamps    = false;
}
