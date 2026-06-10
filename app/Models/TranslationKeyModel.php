<?php

namespace App\Models;

use CodeIgniter\Model;

class TranslationKeyModel extends Model
{
    protected $table            = 'translation_keys';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['key', 'group', 'description'];
    protected $useTimestamps    = false;
}
