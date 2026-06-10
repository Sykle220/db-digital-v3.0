<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSortOrderToBlogPosts extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('blog_posts')) {
            return;
        }

        if (! $this->db->fieldExists('sort_order', 'blog_posts')) {
            $this->forge->addColumn('blog_posts', [
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'default'    => 0,
                    'after'      => 'is_published',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('blog_posts') && $this->db->fieldExists('sort_order', 'blog_posts')) {
            $this->forge->dropColumn('blog_posts', 'sort_order');
        }
    }
}
