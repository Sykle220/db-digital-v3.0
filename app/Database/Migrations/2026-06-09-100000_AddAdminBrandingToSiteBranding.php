<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminBrandingToSiteBranding extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('site_branding')) {
            return;
        }

        if (! $this->db->fieldExists('admin_logo_id', 'site_branding')) {
            $this->forge->addColumn('site_branding', [
                'admin_logo_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'og_default_image_id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('admin_favicon_id', 'site_branding')) {
            $this->forge->addColumn('site_branding', [
                'admin_favicon_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'admin_logo_id',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('site_branding')) {
            return;
        }

        if ($this->db->fieldExists('admin_favicon_id', 'site_branding')) {
            $this->forge->dropColumn('site_branding', 'admin_favicon_id');
        }

        if ($this->db->fieldExists('admin_logo_id', 'site_branding')) {
            $this->forge->dropColumn('site_branding', 'admin_logo_id');
        }
    }
}
