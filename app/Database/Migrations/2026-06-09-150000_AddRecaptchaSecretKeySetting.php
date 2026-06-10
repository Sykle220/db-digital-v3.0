<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRecaptchaSecretKeySetting extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('site_settings')) {
            return;
        }

        $exists = $this->db->table('site_settings')
            ->where('setting_key', 'recaptcha_secret_key')
            ->countAllResults();

        if ($exists === 0) {
            $this->db->table('site_settings')->insert([
                'setting_key'   => 'recaptcha_secret_key',
                'setting_value' => '',
                'setting_group' => 'integrations',
            ]);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('site_settings')) {
            return;
        }

        $this->db->table('site_settings')
            ->where('setting_key', 'recaptcha_secret_key')
            ->delete();
    }
}
