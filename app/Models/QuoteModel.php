<?php

namespace App\Models;

use CodeIgniter\Model;

class QuoteModel extends Model
{
    protected $table            = 'quotes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'service', 'subject', 'project_type', 'budget', 'start_date', 'website',
        'message', 'brief_file', 'fullname', 'company', 'email', 'whatsapp',
        'ip_address', 'user_agent', 'access_token', 'token_expires_at',
        'last_accessed_at', 'status', 'notes',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
