<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContentTables extends Migration
{
    public function up(): void
    {
        // Services
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'icon'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'image'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'detail_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'quote_icon'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'quote_color'  => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'quote_bg'     => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'sort_order'   => ['type' => 'INT', 'default' => 0],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('services', true);

        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'service_id'         => ['type' => 'INT', 'unsigned' => true],
            'locale'             => ['type' => 'CHAR', 'constraint' => 2],
            'title'              => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'        => ['type' => 'TEXT', 'null' => true],
            'intro'              => ['type' => 'TEXT', 'null' => true],
            'body'               => ['type' => 'LONGTEXT', 'null' => true],
            'highlight_title'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'highlight_text'     => ['type' => 'TEXT', 'null' => true],
            'goal_title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'goal_text'          => ['type' => 'TEXT', 'null' => true],
            'challenge_title'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'challenge_text'     => ['type' => 'TEXT', 'null' => true],
            'benefits'           => ['type' => 'JSON', 'null' => true],
            'quote_title_key'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'quote_sub_key'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['service_id', 'locale']);
        $this->forge->addForeignKey('service_id', 'services', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('service_translations', true);

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'service_id' => ['type' => 'INT', 'unsigned' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('service_id', 'services', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('service_faqs', true);

        $this->forge->addField([
            'id'       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'faq_id'   => ['type' => 'INT', 'unsigned' => true],
            'locale'   => ['type' => 'CHAR', 'constraint' => 2],
            'question' => ['type' => 'TEXT'],
            'answer'   => ['type' => 'TEXT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['faq_id', 'locale']);
        $this->forge->addForeignKey('faq_id', 'service_faqs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('faq_translations', true);

        // Blog
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'category_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'image'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'author'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('blog_posts', true);

        $this->forge->addField([
            'id'      => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'slug'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'sort_order' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('blog_categories', true);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'post_id'     => ['type' => 'INT', 'unsigned' => true],
            'locale'      => ['type' => 'CHAR', 'constraint' => 2],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'excerpt'     => ['type' => 'TEXT', 'null' => true],
            'content'     => ['type' => 'LONGTEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['post_id', 'locale']);
        $this->forge->addForeignKey('post_id', 'blog_posts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('blog_post_translations', true);

        $this->forge->addField([
            'id'       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id' => ['type' => 'INT', 'unsigned' => true],
            'locale'   => ['type' => 'CHAR', 'constraint' => 2],
            'name'     => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['category_id', 'locale']);
        $this->forge->addForeignKey('category_id', 'blog_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('blog_category_translations', true);

        // Projects
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'col_lg'     => ['type' => 'TINYINT', 'default' => 4],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('projects', true);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'project_id'  => ['type' => 'INT', 'unsigned' => true],
            'locale'      => ['type' => 'CHAR', 'constraint' => 2],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'category'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['project_id', 'locale']);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('project_translations', true);

        // Team
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('team_members', true);

        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'team_member_id' => ['type' => 'INT', 'unsigned' => true],
            'locale'         => ['type' => 'CHAR', 'constraint' => 2],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['team_member_id', 'locale']);
        $this->forge->addForeignKey('team_member_id', 'team_members', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('team_member_translations', true);

        // Testimonials
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'rating'     => ['type' => 'TINYINT', 'default' => 5],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('testimonials', true);

        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'testimonial_id'  => ['type' => 'INT', 'unsigned' => true],
            'locale'          => ['type' => 'CHAR', 'constraint' => 2],
            'quote'           => ['type' => 'TEXT'],
            'author'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['testimonial_id', 'locale']);
        $this->forge->addForeignKey('testimonial_id', 'testimonials', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('testimonial_translations', true);

        // Brand logos
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'filename'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('brand_logos', true);

        // Office locations
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'lat'        => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'lng'        => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('office_locations', true);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'location_id' => ['type' => 'INT', 'unsigned' => true],
            'locale'      => ['type' => 'CHAR', 'constraint' => 2],
            'city'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'address'     => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'label'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['location_id', 'locale']);
        $this->forge->addForeignKey('location_id', 'office_locations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('office_location_translations', true);

        // Homepage sections
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('homepage_sections', true);

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'section_id' => ['type' => 'INT', 'unsigned' => true],
            'locale'     => ['type' => 'CHAR', 'constraint' => 2],
            'data'       => ['type' => 'JSON', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['section_id', 'locale']);
        $this->forge->addForeignKey('section_id', 'homepage_sections', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('section_translations', true);
    }

    public function down(): void
    {
        foreach (['section_translations', 'homepage_sections', 'office_location_translations', 'office_locations',
            'brand_logos', 'testimonial_translations', 'testimonials', 'team_member_translations', 'team_members',
            'project_translations', 'projects', 'blog_category_translations', 'blog_post_translations',
            'blog_categories', 'blog_posts', 'faq_translations', 'service_faqs', 'service_translations', 'services'] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
