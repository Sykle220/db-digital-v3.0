<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminActivityLog extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'action' => ['type' => 'VARCHAR', 'constraint' => 100],
            'entity_type' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'entity_id' => ['type' => 'INT', 'null' => true],
            'details' => ['type' => 'TEXT', 'null' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('created_at');
        $this->forge->createTable('admin_activity_log', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('admin_activity_log', true);
    }
}
