<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuoteDocumentsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'quote_id'      => ['type' => 'INT', 'unsigned' => true],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('quote_id');
        $this->forge->createTable('quote_documents', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('quote_documents', true);
    }
}
