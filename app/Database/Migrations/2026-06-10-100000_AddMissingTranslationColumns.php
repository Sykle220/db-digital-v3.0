<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingTranslationColumns extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('team_member_translations')
            && ! $this->db->fieldExists('bio', 'team_member_translations')) {
            $this->forge->addColumn('team_member_translations', [
                'bio' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'role',
                ],
            ]);
        }

        if ($this->db->tableExists('project_translations')
            && ! $this->db->fieldExists('client', 'project_translations')) {
            $this->forge->addColumn('project_translations', [
                'client' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'description',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('team_member_translations')
            && $this->db->fieldExists('bio', 'team_member_translations')) {
            $this->forge->dropColumn('team_member_translations', 'bio');
        }

        if ($this->db->tableExists('project_translations')
            && $this->db->fieldExists('client', 'project_translations')) {
            $this->forge->dropColumn('project_translations', 'client');
        }
    }
}
