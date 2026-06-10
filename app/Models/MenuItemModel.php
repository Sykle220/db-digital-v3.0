<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuItemModel extends Model
{
    protected $table            = 'menu_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'menu_id', 'parent_id', 'sort_order', 'type', 'target_id',
        'url', 'icon', 'css_class', 'is_active', 'open_new_tab',
    ];
    protected $useTimestamps = false;
}
