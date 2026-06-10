<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAssetsMinifiedSetting extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('site_settings')) {
            return;
        }

        $exists = $this->db->table('site_settings')
            ->where('setting_key', 'assets_minified')
            ->countAllResults();

        if ($exists === 0) {
            $this->db->table('site_settings')->insert([
                'setting_key'   => 'assets_minified',
                'setting_value' => '0',
                'setting_group' => 'integrations',
            ]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('site_settings')) {
            $this->db->table('site_settings')->where('setting_key', 'assets_minified')->delete();
        }
    }
}
