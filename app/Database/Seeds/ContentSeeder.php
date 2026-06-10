<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContentSeeder extends Seeder
{
    use LegacyConfigTrait;

    public function run(): void
    {
        $this->loadLegacyConfig();

        $vars = $this->legacyVars();

        $categoryMap = $this->seedBlogCategories(
            $vars['blog_categories'] ?? [],
            $vars['blog_posts'] ?? [],
        );

        $this->seedServices($vars['agency_services'] ?? []);
        $this->seedProjects($vars['homepage_projects'] ?? []);
        $this->seedTeam($vars['team_members'] ?? []);
        $this->seedTestimonials($vars['testimonials'] ?? []);
        $this->seedBrandLogos($vars['brand_logos'] ?? []);
        $this->seedOffices($vars['office_locations'] ?? []);
        $this->seedHomepageSections(
            $vars['homepage_features'] ?? [],
            $vars['homepage_counters'] ?? [],
            $vars['company_leadership'] ?? [],
        );
        $this->seedBlogPosts($vars['blog_posts'] ?? [], $categoryMap);
    }

    /**
     * @param list<array<string, mixed>> $services
     */
    protected function seedServices(array $services): void
    {
        if (! $this->db->tableExists('services')) {
            return;
        }

        $sort = 0;
        foreach ($services as $service) {
            $sort++;
            $slug = (string) ($service['slug'] ?? '');

            $existing = $this->db->table('services')->where('slug', $slug)->get()->getRowArray();
            if ($existing) {
                $serviceId = (int) $existing['id'];
                $this->db->table('services')->where('id', $serviceId)->update([
                    'icon'          => $service['icon'] ?? null,
                    'image'         => $service['image'] ?? null,
                    'detail_image'  => $service['detail_image'] ?? null,
                    'quote_icon'    => $service['quote_icon'] ?? null,
                    'quote_color'   => $service['quote_color'] ?? null,
                    'quote_bg'      => $service['quote_bg'] ?? null,
                    'sort_order'    => $sort,
                    'is_active'     => 1,
                ]);
            } else {
                $this->db->table('services')->insert([
                    'slug'          => $slug,
                    'icon'          => $service['icon'] ?? null,
                    'image'         => $service['image'] ?? null,
                    'detail_image'  => $service['detail_image'] ?? null,
                    'quote_icon'    => $service['quote_icon'] ?? null,
                    'quote_color'   => $service['quote_color'] ?? null,
                    'quote_bg'      => $service['quote_bg'] ?? null,
                    'sort_order'    => $sort,
                    'is_active'     => 1,
                ]);
                $serviceId = (int) $this->db->insertID();
            }

            foreach (['fr', 'en'] as $locale) {
                $suffix = $locale === 'fr' ? '_fr' : '_en';
                $data   = [
                    'title'           => $service['title' . $suffix] ?? '',
                    'description'     => $service['description' . $suffix] ?? '',
                    'intro'           => $service['intro' . $suffix] ?? '',
                    'body'            => $service['body' . $suffix] ?? '',
                    'highlight_title' => $service['highlight_title' . $suffix] ?? '',
                    'highlight_text'  => $service['highlight_text' . $suffix] ?? '',
                    'goal_title'      => $service['goal_title' . $suffix] ?? '',
                    'goal_text'       => $service['goal_text' . $suffix] ?? '',
                    'challenge_title' => $service['challenge_title' . $suffix] ?? '',
                    'challenge_text'  => $service['challenge_text' . $suffix] ?? '',
                    'benefits'        => json_encode($service['benefits' . $suffix] ?? [], JSON_UNESCAPED_UNICODE),
                ];

                $this->upsertTranslation('service_translations', 'service_id', $serviceId, $locale, $data);
            }

            if (! empty($service['faq']) && $this->db->tableExists('service_faqs')) {
                $this->db->table('service_faqs')->where('service_id', $serviceId)->delete();
                $faqSort = 0;
                foreach ($service['faq'] as $faq) {
                    $faqSort++;
                    $this->db->table('service_faqs')->insert([
                        'service_id' => $serviceId,
                        'sort_order' => $faqSort,
                    ]);
                    $faqId = (int) $this->db->insertID();

                    foreach (['fr', 'en'] as $locale) {
                        $suffix = $locale === 'fr' ? '_fr' : '_en';
                        $this->upsertTranslation('faq_translations', 'faq_id', $faqId, $locale, [
                            'question' => $faq['q' . $suffix] ?? '',
                            'answer'   => $faq['a' . $suffix] ?? '',
                        ]);
                    }
                }
            }
        }
    }

    /**
     * @param list<array<string, mixed>> $categories
     * @param list<array<string, mixed>> $posts
     *
     * @return array<string, int> slug => category id
     */
    protected function seedBlogCategories(array $categories, array $posts = []): array
    {
        if (! $this->db->tableExists('blog_categories')) {
            return [];
        }

        $map  = [];
        $sort = 0;

        $allCategories = $categories;
        foreach ($posts as $post) {
            $nameEn = (string) ($post['category_en'] ?? '');
            $nameFr = (string) ($post['category_fr'] ?? '');
            if ($nameEn === '' && $nameFr === '') {
                continue;
            }

            $slug = $this->slugify($nameEn !== '' ? $nameEn : $nameFr);
            if (isset($map[$slug])) {
                continue;
            }

            $found = false;
            foreach ($allCategories as $cat) {
                if ($this->slugify((string) ($cat['name_en'] ?? '')) === $slug) {
                    $found = true;
                    break;
                }
            }

            if (! $found) {
                $allCategories[] = [
                    'name_en' => $nameEn !== '' ? $nameEn : $nameFr,
                    'name_fr' => $nameFr !== '' ? $nameFr : $nameEn,
                ];
            }
        }

        foreach ($allCategories as $category) {
            $sort++;
            $slug = $this->slugify((string) ($category['name_en'] ?? $category['name_fr'] ?? 'category-' . $sort));

            $existing = $this->db->table('blog_categories')->where('slug', $slug)->get()->getRowArray();
            if ($existing) {
                $categoryId = (int) $existing['id'];
                $this->db->table('blog_categories')->where('id', $categoryId)->update(['sort_order' => $sort]);
            } else {
                $this->db->table('blog_categories')->insert([
                    'slug'       => $slug,
                    'sort_order' => $sort,
                ]);
                $categoryId = (int) $this->db->insertID();
            }

            $map[$slug] = $categoryId;

            foreach (['fr', 'en'] as $locale) {
                $suffix = $locale === 'fr' ? '_fr' : '_en';
                $this->upsertTranslation('blog_category_translations', 'category_id', $categoryId, $locale, [
                    'name' => $category['name' . $suffix] ?? '',
                ]);
            }
        }

        return $map;
    }

    /**
     * @param list<array<string, mixed>> $features
     * @param list<array<string, mixed>> $counters
     * @param array<string, mixed>       $leadership
     */
    protected function seedHomepageSections(array $features, array $counters, array $leadership): void
    {
        if (! $this->db->tableExists('homepage_sections') || ! $this->db->tableExists('section_translations')) {
            return;
        }

        $featureItemsFr = [];
        $featureItemsEn = [];
        foreach ($features as $feature) {
            $featureItemsFr[] = [
                'icon'      => $feature['icon'] ?? '',
                'title_key' => $feature['title_key'] ?? '',
                'desc'      => $feature['desc_fr'] ?? '',
            ];
            $featureItemsEn[] = [
                'icon'      => $feature['icon'] ?? '',
                'title_key' => $feature['title_key'] ?? '',
                'desc'      => $feature['desc_en'] ?? '',
            ];
        }

        $this->saveHomepageSection('features', [
            'fr' => ['items' => $featureItemsFr],
            'en' => ['items' => $featureItemsEn],
        ]);

        $this->saveHomepageSection('counters', [
            'fr' => $counters,
            'en' => $counters,
        ]);

        $this->saveHomepageSection('leadership', [
            'fr' => $leadership,
            'en' => $leadership,
        ]);
    }

    /**
     * @param array<string, mixed> $byLocale
     */
    protected function saveHomepageSection(string $key, array $byLocale): void
    {
        $section = $this->db->table('homepage_sections')->where('key', $key)->get()->getRowArray();
        if ($section) {
            $sectionId = (int) $section['id'];
        } else {
            $this->db->table('homepage_sections')->insert(['key' => $key, 'sort_order' => 0, 'is_active' => 1]);
            $sectionId = (int) $this->db->insertID();
        }

        foreach ($byLocale as $locale => $data) {
            $this->upsertTranslation('section_translations', 'section_id', $sectionId, $locale, [
                'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    /**
     * @param list<array<string, mixed>> $posts
     * @param array<string, int>        $categoryMap
     */
    protected function seedBlogPosts(array $posts, array $categoryMap = []): void
    {
        if (! $this->db->tableExists('blog_posts')) {
            return;
        }

        foreach ($posts as $index => $post) {
            $slug = $this->slugify((string) ($post['title_en'] ?? 'post-' . ($post['id'] ?? $index)));
            $categorySlug = $this->slugify((string) ($post['category_en'] ?? ''));
            $categoryId   = $categoryMap[$categorySlug] ?? null;

            $existing = $this->db->table('blog_posts')->where('slug', $slug)->get()->getRowArray();
            $payload  = [
                'slug'         => $slug,
                'image'        => $post['image'] ?? null,
                'author'       => $post['author'] ?? 'DB Digital Team',
                'published_at' => $this->parseDate($post['date'] ?? null),
                'is_published' => 1,
                'sort_order'   => $index + 1,
                'category_id'  => $categoryId,
            ];

            if ($existing) {
                $postId = (int) $existing['id'];
                $this->db->table('blog_posts')->where('id', $postId)->update($payload);
            } else {
                $this->db->table('blog_posts')->insert($payload);
                $postId = (int) $this->db->insertID();
            }

            foreach (['fr', 'en'] as $locale) {
                $suffix = $locale === 'fr' ? '_fr' : '_en';
                $this->upsertTranslation('blog_post_translations', 'post_id', $postId, $locale, [
                    'title'   => $post['title' . $suffix] ?? '',
                    'excerpt' => $post['excerpt' . $suffix] ?? '',
                    'content' => $post['excerpt' . $suffix] ?? '',
                ]);
            }
        }
    }

    /**
     * @param list<array<string, mixed>> $projects
     */
    protected function seedProjects(array $projects): void
    {
        if (! $this->db->tableExists('projects')) {
            return;
        }

        foreach ($projects as $index => $project) {
            $slug = $this->slugify((string) ($project['title_en'] ?? 'project-' . ($project['id'] ?? $index)));

            $existing = $this->db->table('projects')->where('slug', $slug)->get()->getRowArray();
            if ($existing) {
                $projectId = (int) $existing['id'];
            } else {
                $this->db->table('projects')->insert([
                    'slug'       => $slug,
                    'image'      => $project['img'] ?? null,
                    'col_lg'     => (int) ($project['col_lg'] ?? 6),
                    'sort_order' => $index + 1,
                    'is_active'  => 1,
                ]);
                $projectId = (int) $this->db->insertID();
            }

            foreach (['fr', 'en'] as $locale) {
                $suffix = $locale === 'fr' ? '_fr' : '_en';
                $this->upsertTranslation('project_translations', 'project_id', $projectId, $locale, [
                    'title'       => $project['title' . $suffix] ?? '',
                    'category'    => $project['category' . $suffix] ?? '',
                    'description' => '',
                ]);
            }
        }
    }

    /**
     * @param list<array<string, mixed>> $members
     */
    protected function seedTeam(array $members): void
    {
        if (! $this->db->tableExists('team_members')) {
            return;
        }

        foreach ($members as $index => $member) {
            $image = $member['img'] ?? null;

            $existing = $this->db->table('team_members')
                ->where('image', $image)
                ->get()
                ->getRowArray();

            if ($existing) {
                $memberId = (int) $existing['id'];
            } else {
                $this->db->table('team_members')->insert([
                    'image'      => $image,
                    'sort_order' => $index + 1,
                    'is_active'  => 1,
                ]);
                $memberId = (int) $this->db->insertID();
            }

            $roleKey = (string) ($member['role_key'] ?? '');
            foreach (['fr', 'en'] as $locale) {
                $role = $this->translationValue($roleKey, $locale);
                $this->upsertTranslation('team_member_translations', 'team_member_id', $memberId, $locale, [
                    'name' => $member['name'] ?? '',
                    'role' => $role,
                ]);
            }
        }
    }

    /**
     * @param list<array<string, mixed>> $items
     */
    protected function seedTestimonials(array $items): void
    {
        if (! $this->db->tableExists('testimonials')) {
            return;
        }

        foreach ($items as $index => $item) {
            $image = $item['img'] ?? null;

            $existing = $this->db->table('testimonials')
                ->where('image', $image)
                ->get()
                ->getRowArray();

            if ($existing) {
                $testimonialId = (int) $existing['id'];
            } else {
                $this->db->table('testimonials')->insert([
                    'image'      => $image,
                    'rating'     => 5,
                    'sort_order' => $index + 1,
                    'is_active'  => 1,
                ]);
                $testimonialId = (int) $this->db->insertID();
            }

            foreach (['fr', 'en'] as $locale) {
                $suffix = $locale === 'fr' ? '_fr' : '_en';
                $this->upsertTranslation('testimonial_translations', 'testimonial_id', $testimonialId, $locale, [
                    'author' => $item['name'] ?? '',
                    'role'   => $item['role' . $suffix] ?? '',
                    'quote'  => $item['quote' . $suffix] ?? '',
                ]);
            }
        }
    }

    /**
     * @param list<string> $logos
     */
    protected function seedBrandLogos(array $logos): void
    {
        if (! $this->db->tableExists('brand_logos')) {
            return;
        }

        foreach ($logos as $index => $filename) {
            $existing = $this->db->table('brand_logos')
                ->where('filename', $filename)
                ->get()
                ->getRowArray();

            if ($existing) {
                continue;
            }

            $this->db->table('brand_logos')->insert([
                'filename'   => $filename,
                'name'       => pathinfo($filename, PATHINFO_FILENAME),
                'sort_order' => $index + 1,
                'is_active'  => 1,
            ]);
        }
    }

    /**
     * @param list<array<string, mixed>> $offices
     */
    protected function seedOffices(array $offices): void
    {
        if (! $this->db->tableExists('office_locations')) {
            return;
        }

        foreach ($offices as $index => $office) {
            $email = (string) ($office['email'] ?? '');

            $existing = $this->db->table('office_locations')
                ->where('email', $email)
                ->get()
                ->getRowArray();

            if ($existing) {
                $locationId = (int) $existing['id'];
                $this->db->table('office_locations')->where('id', $locationId)->update([
                    'phone'      => $office['phone'] ?? null,
                    'lat'        => $office['lat'] ?? null,
                    'lng'        => $office['lng'] ?? null,
                    'image'      => $office['image'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active'  => 1,
                ]);
            } else {
                $this->db->table('office_locations')->insert([
                    'email'      => $email,
                    'phone'      => $office['phone'] ?? null,
                    'lat'        => $office['lat'] ?? null,
                    'lng'        => $office['lng'] ?? null,
                    'image'      => $office['image'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active'  => 1,
                ]);
                $locationId = (int) $this->db->insertID();
            }

            foreach (['fr', 'en'] as $locale) {
                $suffix = $locale === 'fr' ? '_fr' : '_en';
                $this->upsertTranslation('office_location_translations', 'location_id', $locationId, $locale, [
                    'city'    => $office['city'] ?? '',
                    'label'   => $office['label' . $suffix] ?? '',
                    'address' => $office['address'] ?? '',
                ]);
            }
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function upsertTranslation(string $table, string $foreignKey, int $entityId, string $locale, array $data): void
    {
        if (! $this->db->tableExists($table)) {
            return;
        }

        $row = $this->db->table($table)
            ->where($foreignKey, $entityId)
            ->where('locale', $locale)
            ->get()
            ->getRowArray();

        $payload = array_merge($data, [
            $foreignKey => $entityId,
            'locale'    => $locale,
        ]);

        if ($row) {
            unset($payload[$foreignKey], $payload['locale']);
            $this->db->table($table)->where('id', $row['id'])->update($payload);
        } else {
            $this->db->table($table)->insert($payload);
        }
    }

    protected function translationValue(string $key, string $locale): string
    {
        if ($key === '' || ! $this->db->tableExists('translation_keys')) {
            return $key;
        }

        $row = $this->db->table('translation_keys tk')
            ->select('tv.value')
            ->join('translation_values tv', 'tv.key_id = tk.id', 'left')
            ->where('tk.key', $key)
            ->where('tv.locale', $locale)
            ->get()
            ->getRowArray();

        return (string) ($row['value'] ?? $key);
    }

    protected function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? $value;

        return trim($value, '-') ?: 'item';
    }

    protected function parseDate(?string $date): ?string
    {
        if ($date === null || $date === '') {
            return null;
        }

        $timestamp = strtotime($date);

        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
    }
}
