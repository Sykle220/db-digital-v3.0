<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLegacyFormTables extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('quotes')) {
            $this->forge->addField([
                'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'service'     => ['type' => 'TEXT'],
                'subject'     => ['type' => 'VARCHAR', 'constraint' => 255],
                'project_type'=> ['type' => 'VARCHAR', 'constraint' => 100],
                'budget'      => ['type' => 'VARCHAR', 'constraint' => 50],
                'start_date'  => ['type' => 'VARCHAR', 'constraint' => 50],
                'website'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'message'     => ['type' => 'TEXT', 'null' => true],
                'brief_file'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'fullname'    => ['type' => 'VARCHAR', 'constraint' => 255],
                'company'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'email'       => ['type' => 'VARCHAR', 'constraint' => 255],
                'whatsapp'    => ['type' => 'VARCHAR', 'constraint' => 50],
                'ip_address'  => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
                'user_agent'  => ['type' => 'TEXT', 'null' => true],
                'access_token'=> ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
                'token_expires_at' => ['type' => 'DATETIME', 'null' => true],
                'last_accessed_at' => ['type' => 'DATETIME', 'null' => true],
                'status'      => ['type' => 'ENUM', 'constraint' => ['new', 'contacted', 'in_progress', 'completed', 'cancelled'], 'default' => 'new'],
                'notes'       => ['type' => 'TEXT', 'null' => true],
                'created_at'  => ['type' => 'DATETIME', 'null' => true],
                'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('access_token');
            $this->forge->addKey('email');
            $this->forge->addKey('status');
            $this->forge->createTable('quotes');
        } else {
            $fields = $this->db->getFieldNames('quotes');
            if (! in_array('access_token', $fields, true)) {
                $this->forge->addColumn('quotes', [
                    'access_token'     => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'after' => 'user_agent'],
                    'token_expires_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'access_token'],
                    'last_accessed_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'token_expires_at'],
                ]);
                $this->db->query('ALTER TABLE quotes ADD UNIQUE KEY uq_access_token (access_token)');
            }
        }

        if (! $this->db->tableExists('quote_services')) {
            $this->forge->addField([
                'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'quote_id'    => ['type' => 'INT', 'unsigned' => true],
                'service_key' => ['type' => 'VARCHAR', 'constraint' => 64],
                'created_at'  => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('quote_id', 'quotes', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('quote_services');
        }

        if (! $this->db->tableExists('quote_logs')) {
            $this->forge->addField([
                'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'quote_id'       => ['type' => 'INT', 'unsigned' => true],
                'action_type'    => ['type' => 'ENUM', 'constraint' => ['email_sent', 'whatsapp_click', 'email_failed', 'prospect_access', 'status_change', 'document_upload']],
                'action_details' => ['type' => 'TEXT', 'null' => true],
                'created_at'     => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('quote_id', 'quotes', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('quote_logs');
        }

        if (! $this->db->tableExists('contact_messages')) {
            $this->forge->addField([
                'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'name'       => ['type' => 'VARCHAR', 'constraint' => 255],
                'phone'      => ['type' => 'VARCHAR', 'constraint' => 50],
                'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
                'message'    => ['type' => 'TEXT'],
                'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
                'user_agent' => ['type' => 'TEXT', 'null' => true],
                'status'     => ['type' => 'ENUM', 'constraint' => ['new', 'read', 'replied', 'archived'], 'default' => 'new'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('contact_messages');
        }

        if (! $this->db->tableExists('newsletter_subscribers')) {
            $this->forge->addField([
                'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
                'lang'       => ['type' => 'CHAR', 'constraint' => 2, 'default' => 'fr'],
                'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
                'user_agent' => ['type' => 'TEXT', 'null' => true],
                'status'     => ['type' => 'ENUM', 'constraint' => ['active', 'unsubscribed'], 'default' => 'active'],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('email');
            $this->forge->createTable('newsletter_subscribers');
        }

        if (! $this->db->tableExists('prospect_activity_logs')) {
            $this->forge->addField([
                'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'quote_id'   => ['type' => 'INT', 'unsigned' => true],
                'action'     => ['type' => 'VARCHAR', 'constraint' => 100],
                'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('quote_id', 'quotes', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('prospect_activity_logs');
        }
    }

    public function down(): void
    {
        $this->forge->dropTable('prospect_activity_logs', true);
    }
}