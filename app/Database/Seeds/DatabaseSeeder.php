<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('TranslationSeeder');
        $this->call('MenuSeeder');
        $this->call('SettingsSeeder');
        $this->call('MediaSeeder');
        $this->call('ContentSeeder');
        $this->call('BrandingSeeder');
        $this->call('SeoSeeder');
        $this->call('PageSeeder');
        $this->call('SeoMetaSeeder');
        $this->call('AdminUserSeeder');
    }
}
