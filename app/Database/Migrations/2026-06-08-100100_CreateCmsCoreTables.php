<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCmsCoreTables extends Migration
{
    public function up(): void
    {
        // Settings
        if (! $this->db->tableExists('settings')) {
            $this->forge->addField([
                'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                'setting_key'  => ['type' => 'VARCHAR', 'constraint' => 100],
                'setting_value'=> ['type' => 'TEXT', 'null' => true],
                'setting_group'=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'general'],
                'created_at'   => ['type' => 'DATETIME', 'null' => true],
                'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('setting_key');
            $this->forge->createTable('settings');
        }

        // Media
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'mime_type'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'size'          => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'disk'          => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'local'],
            'folder'        => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'general'],
            'alt_text'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'width'         => ['type' => 'INT', 'null' => true],
            'height'        => ['type' => 'INT', 'null' => true],
            'uploaded_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('media', true);

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'media_id'   => ['type' => 'INT', 'unsigned' => true],
            'locale'     => ['type' => 'CHAR', 'constraint' => 2],
            'alt_text'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'caption'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('media_id', 'media', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('media_translations', true);

        // Pages
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'template'     => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'default'],
            'sort_order'   => ['type' => 'INT', 'default' => 0],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pages', true);

        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'page_id'          => ['type' => 'INT', 'unsigned' => true],
            'locale'           => ['type' => 'CHAR', 'constraint' => 2],
            'title'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'excerpt'          => ['type' => 'TEXT', 'null' => true],
            'content'          => ['type' => 'LONGTEXT', 'null' => true],
            'meta_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_image_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['page_id', 'locale']);
        $this->forge->addKey(['locale', 'slug']);
        $this->forge->addForeignKey('page_id', 'pages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('page_translations', true);

        // Menus
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('menus', true);

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'menu_id'      => ['type' => 'INT', 'unsigned' => true],
            'parent_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'sort_order'   => ['type' => 'INT', 'default' => 0],
            'type'         => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'url'],
            'target_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'url'          => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'icon'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'css_class'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'open_new_tab' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('menu_id', 'menus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_items', true);

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'menu_item_id' => ['type' => 'INT', 'unsigned' => true],
            'locale'       => ['type' => 'CHAR', 'constraint' => 2],
            'label'        => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['menu_item_id', 'locale']);
        $this->forge->addForeignKey('menu_item_id', 'menu_items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_item_translations', true);

        // Translations UI
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'group'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'general'],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('translation_keys', true);

        $this->forge->addField([
            'id'     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key_id' => ['type' => 'INT', 'unsigned' => true],
            'locale' => ['type' => 'CHAR', 'constraint' => 2],
            'value'  => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['key_id', 'locale']);
        $this->forge->addForeignKey('key_id', 'translation_keys', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('translation_values', true);

        // Branding
        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'logo_light_id'        => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'logo_dark_id'         => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'logo_mobile_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'favicon_id'           => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'apple_touch_icon_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'og_default_image_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('site_branding', true);

        // SEO
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'entity_type'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'entity_id'        => ['type' => 'INT', 'unsigned' => true],
            'locale'           => ['type' => 'CHAR', 'constraint' => 2],
            'meta_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'meta_keywords'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'og_description'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'og_image_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'canonical_url'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'robots'           => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'index,follow'],
            'schema_json'      => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['entity_type', 'entity_id', 'locale']);
        $this->forge->createTable('seo_meta', true);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'from_path'   => ['type' => 'VARCHAR', 'constraint' => 500],
            'to_path'     => ['type' => 'VARCHAR', 'constraint' => 500],
            'status_code' => ['type' => 'SMALLINT', 'default' => 301],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('from_path');
        $this->forge->createTable('seo_redirects', true);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'entity_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'changefreq'  => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'weekly'],
            'priority'    => ['type' => 'DECIMAL', 'constraint' => '2,1', 'default' => 0.5],
            'is_included' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('entity_type');
        $this->forge->createTable('seo_sitemap_config', true);
    }

    public function down(): void
    {
        foreach (['seo_sitemap_config', 'seo_redirects', 'seo_meta', 'site_branding',
            'translation_values', 'translation_keys', 'menu_item_translations', 'menu_items',
            'menus', 'page_translations', 'pages', 'media_translations', 'media', 'settings'] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
