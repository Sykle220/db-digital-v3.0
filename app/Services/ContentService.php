<?php

namespace App\Services;

use App\Libraries\DbGuard;
use App\Models\BrandLogoModel;
use App\Models\OfficeLocationModel;
use App\Models\ProjectModel;
use App\Models\ServiceModel;
use App\Models\TeamMemberModel;
use App\Models\TestimonialModel;

class ContentService
{
    protected ServiceModel $serviceModel;
    protected ProjectModel $projectModel;
    protected TeamMemberModel $teamModel;
    protected TestimonialModel $testimonialModel;
    protected BrandLogoModel $brandLogoModel;
    protected OfficeLocationModel $officeModel;

    public function __construct(
        ?ServiceModel $serviceModel = null,
        ?ProjectModel $projectModel = null,
        ?TeamMemberModel $teamModel = null,
        ?TestimonialModel $testimonialModel = null,
        ?BrandLogoModel $brandLogoModel = null,
        ?OfficeLocationModel $officeModel = null,
    ) {
        $this->serviceModel     = $serviceModel ?? model(ServiceModel::class);
        $this->projectModel     = $projectModel ?? model(ProjectModel::class);
        $this->teamModel        = $teamModel ?? model(TeamMemberModel::class);
        $this->testimonialModel = $testimonialModel ?? model(TestimonialModel::class);
        $this->brandLogoModel   = $brandLogoModel ?? model(BrandLogoModel::class);
        $this->officeModel      = $officeModel ?? model(OfficeLocationModel::class);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getServices(?string $locale = null, bool $activeOnly = true): array
    {
        if (! DbGuard::available()) {
            return $this->defaultServices($locale);
        }

        $locale = $this->resolveLocale($locale);
        $builder = $this->serviceModel->orderBy('sort_order', 'ASC');

        if ($activeOnly) {
            $builder->where('is_active', 1);
        }

        $services = $builder->findAll();

        if ($services === []) {
            return $this->defaultServices($locale);
        }

        return $this->mergeTranslations($services, 'service_translations', 'service_id', $locale);
    }

    public function getServiceBySlug(string $slug, ?string $locale = null): ?array
    {
        if (! DbGuard::available()) {
            foreach ($this->defaultServices($locale) as $service) {
                if (($service['slug'] ?? '') === $slug) {
                    return $service;
                }
            }

            return null;
        }

        $locale  = $this->resolveLocale($locale);
        $service = $this->serviceModel->where('slug', $slug)->where('is_active', 1)->first();

        if ($service === null) {
            return null;
        }

        $merged = $this->mergeTranslations([$service], 'service_translations', 'service_id', $locale);
        $serviceRow = $merged[0] ?? null;

        if ($serviceRow === null) {
            return null;
        }

        $serviceRow['faq'] = $this->loadServiceFaqs((int) $serviceRow['id'], $locale);

        return $serviceRow;
    }

    public function getOfficeBySlug(string $slug, ?string $locale = null): ?array
    {
        $slug = strtolower(trim($slug));
        $offices = $this->getOffices($locale);

        foreach ($offices as $office) {
            $key = strtolower((string) ($office['key'] ?? ''));
            if ($key === $slug) {
                return $office;
            }
        }

        return null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function loadServiceFaqs(int $serviceId, ?string $locale = null): array
    {
        if (! DbGuard::available() || ! $this->serviceModel->db->tableExists('service_faqs')) {
            return [];
        }

        $locale = $this->resolveLocale($locale);
        $db     = $this->serviceModel->db;

        $faqs = $db->table('service_faqs')
            ->where('service_id', $serviceId)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();

        $items = [];
        foreach ($faqs as $faq) {
            $faqId = (int) ($faq['id'] ?? 0);
            $row   = ['id' => $faqId];

            foreach (['fr', 'en'] as $loc) {
                $tr = $db->table('faq_translations')
                    ->where('faq_id', $faqId)
                    ->where('locale', $loc)
                    ->get()
                    ->getRowArray();

                $question = (string) ($tr['question'] ?? '');
                $answer   = (string) ($tr['answer'] ?? '');

                $row['question_' . $loc] = $question;
                $row['answer_' . $loc]   = $answer;
                $row['q_' . $loc]        = $question;
                $row['a_' . $loc]        = $answer;
            }

            if (trim($row['question_' . $locale] ?? '') !== '') {
                $items[] = $row;
            }
        }

        return $items;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getProjects(?string $locale = null, bool $activeOnly = true): array
    {
        if (! DbGuard::available()) {
            return $this->defaultProjects($locale);
        }

        $locale = $this->resolveLocale($locale);
        $builder = $this->projectModel->orderBy('sort_order', 'ASC');

        if ($activeOnly) {
            $builder->where('is_active', 1);
        }

        $projects = $builder->findAll();

        if ($projects === []) {
            return $this->defaultProjects($locale);
        }

        return $this->mergeTranslations($projects, 'project_translations', 'project_id', $locale);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getTeam(?string $locale = null, bool $activeOnly = true): array
    {
        if (! DbGuard::available()) {
            return $this->defaultTeam($locale);
        }

        $locale = $this->resolveLocale($locale);
        $builder = $this->teamModel->orderBy('sort_order', 'ASC');

        if ($activeOnly) {
            $builder->where('is_active', 1);
        }

        $members = $this->mergeTranslations($builder->findAll(), 'team_member_translations', 'team_member_id', $locale);

        if ($members === []) {
            return $this->defaultTeam($locale);
        }

        foreach ($members as &$member) {
            if (! empty($member['image']) && ! str_starts_with((string) $member['image'], 'http')) {
                $member['image_url'] = asset_url('img/team/' . ltrim((string) $member['image'], '/'));
            }
        }
        unset($member);

        return $members;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getTestimonials(?string $locale = null, bool $activeOnly = true): array
    {
        if (! DbGuard::available()) {
            return $this->defaultTestimonials($locale);
        }

        $locale = $this->resolveLocale($locale);
        $builder = $this->testimonialModel->orderBy('sort_order', 'ASC');

        if ($activeOnly) {
            $builder->where('is_active', 1);
        }

        $items = $this->mergeTranslations($builder->findAll(), 'testimonial_translations', 'testimonial_id', $locale);

        if ($items === []) {
            return $this->defaultTestimonials($locale);
        }

        foreach ($items as &$item) {
            $filename = (string) ($item['image'] ?? '');
            $item['image_url'] = $this->testimonialImageUrl($filename);
            if (empty($item['name']) && ! empty($item['author'])) {
                $item['name'] = (string) $item['author'];
            }
        }
        unset($item);

        return $items;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getBrandLogos(bool $activeOnly = true): array
    {
        if (! DbGuard::available()) {
            return $this->defaultBrandLogos();
        }

        $builder = $this->brandLogoModel->orderBy('sort_order', 'ASC');

        if ($activeOnly) {
            $builder->where('is_active', 1);
        }

        $logos = $builder->findAll();

        if ($logos === []) {
            return $this->defaultBrandLogos();
        }

        foreach ($logos as &$logo) {
            $logo['url'] = asset_url('img/brand/' . ltrim((string) $logo['filename'], '/'));
        }
        unset($logo);

        return $logos;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getOffices(?string $locale = null, bool $activeOnly = true): array
    {
        if (! DbGuard::available()) {
            return [];
        }

        $locale = $this->resolveLocale($locale);
        $builder = $this->officeModel->orderBy('sort_order', 'ASC');

        if ($activeOnly) {
            $builder->where('is_active', 1);
        }

        $offices = $this->mergeTranslations($builder->findAll(), 'office_location_translations', 'location_id', $locale);

        if ($offices === []) {
            return $this->defaultOffices($locale);
        }

        foreach ($offices as &$office) {
            if (empty($office['key']) && ! empty($office['email'])) {
                $office['key'] = (string) strstr((string) $office['email'], '@', true);
            }
            if (! empty($office['image']) && ! str_starts_with((string) $office['image'], 'http')) {
                $office['image_url'] = asset_url('img/images/' . ltrim((string) $office['image'], '/'));
            }
        }
        unset($office);

        return $offices;
    }

    /**
     * @param list<array<string, mixed>> $entities
     *
     * @return list<array<string, mixed>>
     */
    protected function mergeTranslations(array $entities, string $table, string $foreignKey, string $locale): array
    {
        if ($entities === []) {
            return [];
        }

        $ids = array_column($entities, 'id');
        $db  = $this->serviceModel->db;

        if (! $db->tableExists($table)) {
            return $entities;
        }

        $translations = $db->table($table)
            ->whereIn($foreignKey, $ids)
            ->where('locale', $locale)
            ->get()
            ->getResultArray();

        $byEntity = [];
        foreach ($translations as $row) {
            $entityId = (int) $row[$foreignKey];
            unset($row['id'], $row[$foreignKey], $row['locale']);
            $byEntity[$entityId] = $row;
        }

        $fallbackLocale = $locale === 'fr' ? 'en' : 'fr';
        $fallbackRows   = [];

        if ($byEntity === [] || count($byEntity) < count($ids)) {
            $fallbackRows = $db->table($table)
                ->whereIn($foreignKey, $ids)
                ->where('locale', $fallbackLocale)
                ->get()
                ->getResultArray();
        }

        $byFallback = [];
        foreach ($fallbackRows as $row) {
            $entityId = (int) $row[$foreignKey];
            unset($row['id'], $row[$foreignKey], $row['locale']);
            $byFallback[$entityId] = $row;
        }

        $result = [];
        foreach ($entities as $entity) {
            $id = (int) $entity['id'];
            $translation = $byEntity[$id] ?? $byFallback[$id] ?? [];
            $entity['translation'] = $translation;
            $result[] = array_merge($entity, $translation);
        }

        return $result;
    }

    protected function testimonialImageUrl(string $filename): string
    {
        if ($filename === '') {
            return asset_url('img/images/temoignage.png');
        }

        $path = FCPATH . 'assets/img/images/' . $filename;
        if (is_file($path)) {
            return asset_url('img/images/' . $filename);
        }

        return asset_url('img/images/temoignage.png');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getHomepageFeatures(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);
        $stored = $this->getHomepageSectionItems('features', $locale);

        if ($stored !== null) {
            return $stored;
        }

        return [
            ['icon' => 'flaticon-layers', 'title_key' => 'features_growing', 'desc' => $locale === 'fr' ? 'Stratégie et parcours pensés conversion.' : 'Strategy and journeys built to convert.'],
            ['icon' => 'flaticon-mission', 'title_key' => 'features_finance', 'desc' => $locale === 'fr' ? 'Acquisition optimisée pour le ROI.' : 'Acquisition systems optimized for ROI.'],
            ['icon' => 'flaticon-profit', 'title_key' => 'features_tax', 'desc' => $locale === 'fr' ? 'Marque et UX qui rassurent vite.' : 'Brand and UX that build trust fast.'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getHomepageCounters(): array
    {
        $stored = $this->getHomepageSectionItems('counters', 'fr');

        if ($stored !== null) {
            return $stored;
        }

        return [
            ['icon' => 'flaticon-folder-1', 'label_key' => 'counter_projects', 'count' => 9525],
            ['icon' => 'flaticon-rating', 'label_key' => 'counter_clients', 'count' => 11985],
            ['icon' => 'flaticon-trophy', 'label_key' => 'counter_awards', 'count' => 4722],
            ['icon' => 'flaticon-puzzle-piece', 'label_key' => 'counter_countries', 'count' => 115],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getCompanyLeadership(): array
    {
        $stored = $this->getHomepageSectionData('leadership', 'fr');

        if (is_array($stored) && $stored !== []) {
            return $stored;
        }

        return [
            'ceo_name'          => 'Eugénie Rose Yuoyang',
            'ceo_image'         => 'about_ceo.png',
            'signature_image'   => 'signature.png',
            'experience_years'  => '15+',
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getAboutSkills(): array
    {
        return [
            ['label_key' => 'about_skill_strategy', 'percent' => 90, 'delay' => '.1s'],
            ['label_key' => 'about_skill_brand', 'percent' => 76, 'delay' => '.2s'],
            ['label_key' => 'about_skill_growth', 'percent' => 85, 'delay' => '.3s'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getHomepageProjects(?string $locale = null, int $limit = 5): array
    {
        $projects = $this->getProjects($locale);
        if ($projects !== []) {
            return array_slice($projects, 0, $limit);
        }

        return $this->defaultProjects($locale);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getBlogPosts(?string $locale = null): array
    {
        if (! DbGuard::available()) {
            return $this->defaultBlogPosts($locale);
        }

        $locale = $this->resolveLocale($locale);
        $db     = $this->serviceModel->db;

        if ($db->tableExists('blog_posts')) {
            $posts = $db->table('blog_posts')
                ->where('is_published', 1)
                ->orderBy('published_at', 'DESC')
                ->get()
                ->getResultArray();

            if ($posts !== []) {
                return $this->mergeTranslations($posts, 'blog_post_translations', 'post_id', $locale);
            }
        }

        return $this->defaultBlogPosts($locale);
    }

    public function getBlogPostBySlug(string $slug, ?string $locale = null): ?array
    {
        foreach ($this->getBlogPosts($locale) as $post) {
            if (($post['slug'] ?? '') === $slug) {
                return $post;
            }
        }

        return null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getBlogCategories(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);

        if (! DbGuard::available()) {
            return $this->defaultBlogCategories($locale);
        }

        $db = $this->serviceModel->db;
        if (! $db->tableExists('blog_categories')) {
            return $this->defaultBlogCategories($locale);
        }

        $categories = $db->table('blog_categories')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();

        if ($categories === []) {
            return $this->defaultBlogCategories($locale);
        }

        $merged = $this->mergeTranslations($categories, 'blog_category_translations', 'category_id', $locale);

        foreach ($merged as &$category) {
            $category['name']  = (string) ($category['name'] ?? '');
            $category['count'] = $db->table('blog_posts')
                ->where('category_id', (int) $category['id'])
                ->where('is_published', 1)
                ->countAllResults();
        }
        unset($category);

        return $merged;
    }

    /**
     * @return list<array<string, string>>
     */
    public function getBlogTags(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);
        $stored = $this->loadBlogTagsFromSettings();

        if ($stored !== []) {
            $result = [];
            foreach ($stored as $tag) {
                if (! is_array($tag)) {
                    continue;
                }
                $name = (string) ($tag[$locale] ?? $tag['en'] ?? $tag['fr'] ?? '');
                if ($name !== '') {
                    $result[] = ['name' => $name];
                }
            }

            if ($result !== []) {
                return $result;
            }
        }

        return $this->defaultBlogTags($locale);
    }

    public function getPageBySlug(string $slug, ?string $locale = null): ?array
    {
        if (! DbGuard::available()) {
            return null;
        }

        $locale = $this->resolveLocale($locale);
        $db     = $this->serviceModel->db;

        if (! $db->tableExists('page_translations')) {
            return null;
        }

        $row = $db->table('page_translations pt')
            ->select('pt.*, p.template, p.is_published, p.published_at, p.id AS page_id')
            ->join('pages p', 'p.id = pt.page_id')
            ->where('pt.slug', $slug)
            ->where('pt.locale', $locale)
            ->where('p.is_published', 1)
            ->get()
            ->getRowArray();

        return $row ?: null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getContactDepartments(): array
    {
        return [
            ['icon' => 'fa-shopping-bag', 'title_key' => 'contact_sales_title', 'email' => 'sales@dbdigitalagency.com', 'desc_key' => 'contact_sales_desc'],
            ['icon' => 'fa-envelope-open-text', 'title_key' => 'contact_general_title', 'email' => 'contact@dbdigitalagency.com', 'desc_key' => 'contact_general_desc'],
            ['icon' => 'fa-headset', 'title_key' => 'contact_support_title', 'email' => 'support@dbdigitalagency.com', 'desc_key' => 'contact_support_desc'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultProjects(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);

        $items = [
            ['img' => 'h5_project_img01.jpg', 'title_en' => 'Illustration Design', 'title_fr' => 'Design d\'Illustration', 'category_en' => 'Creative Work', 'category_fr' => 'Travail Créatif', 'col_lg' => 6],
            ['img' => 'h5_project_img02.jpg', 'title_en' => 'Design & Development', 'title_fr' => 'Design & Développement', 'category_en' => 'Planing', 'category_fr' => 'Planification', 'col_lg' => 6],
            ['img' => 'h5_project_img03.jpg', 'title_en' => 'Marketing Consultancy', 'title_fr' => 'Conseil en Marketing', 'category_en' => 'Development', 'category_fr' => 'Développement', 'col_lg' => 4],
            ['img' => 'h5_project_img04.jpg', 'title_en' => 'Digital Marketing', 'title_fr' => 'Marketing Digital', 'category_en' => 'Skill Development', 'category_fr' => 'Développement de Compétences', 'col_lg' => 4],
            ['img' => 'h5_project_img05.jpg', 'title_en' => 'Strategic Planning', 'title_fr' => 'Planification Stratégique', 'category_en' => 'Marketing', 'category_fr' => 'Marketing', 'col_lg' => 4],
        ];

        $suffix = $locale === 'fr' ? '_fr' : '_en';
        foreach ($items as &$item) {
            $item['title']    = $item['title' . $suffix];
            $item['category'] = $item['category' . $suffix];
        }
        unset($item);

        return $items;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultBlogPosts(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);
        $suffix = $locale === 'fr' ? '_fr' : '_en';

        $posts = [
            ['slug' => 'digital-brand-cameroon', 'title_en' => 'How to Launch a Strong Digital Brand in Cameroon', 'title_fr' => 'Comment Lancer une Marque Digitale Forte au Cameroun', 'excerpt_en' => 'Step-by-step guidance to build an impactful digital brand for local audiences.', 'excerpt_fr' => 'Guide étape par étape pour construire une marque digitale forte adaptée au marché camerounais.', 'image' => 'h3_blog_img01.jpg', 'avatar' => 'blog_avatar01.png', 'author' => 'DB Digital Team', 'date' => '22 Jan, 2023', 'category_en' => 'Branding', 'category_fr' => 'Branding'],
            ['slug' => 'digital-transformation-smes', 'title_en' => 'Digital Transformation for African SMEs', 'title_fr' => 'Transformation Digitale pour les PME Africaines', 'excerpt_en' => 'How small and medium businesses in Cameroon can thrive with the right digital tools.', 'excerpt_fr' => 'Comment les petites et moyennes entreprises camerounaises peuvent prospérer avec les bons outils digitaux.', 'image' => 'h3_blog_img02.jpg', 'avatar' => 'blog_avatar02.png', 'author' => 'DB Digital Team', 'date' => '25 Jan, 2023', 'category_en' => 'Strategy', 'category_fr' => 'Stratégie'],
            ['slug' => 'growth-marketing-startups', 'title_en' => 'Growth Marketing for Startups in Cameroon', 'title_fr' => 'Marketing de Croissance pour les Startups au Cameroun', 'excerpt_en' => 'Performance marketing tactics to turn traffic into paying customers.', 'excerpt_fr' => 'Tactiques de marketing de performance pour transformer le trafic en clients payants.', 'image' => 'h3_blog_img03.jpg', 'avatar' => 'blog_avatar03.png', 'author' => 'DB Digital Team', 'date' => '28 Jan, 2023', 'category_en' => 'Marketing', 'category_fr' => 'Marketing'],
        ];

        foreach ($posts as &$post) {
            $post['title']    = $post['title' . $suffix];
            $post['excerpt']  = $post['excerpt' . $suffix];
            $post['category'] = $post['category' . $suffix];
        }
        unset($post);

        return $posts;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultServices(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);
        $suffix = $locale === 'fr' ? '_fr' : '_en';

        $items = [
            ['slug' => 'digital-strategy', 'icon' => 'flaticon-mission', 'image' => 'h4_services_img01.jpg', 'title_en' => 'Digital Strategy', 'title_fr' => 'Stratégie Digitale', 'description_en' => 'Positioning, messaging, customer journey and a clear execution plan.', 'description_fr' => 'Positionnement, message, parcours client et plan d\'exécution clair.'],
            ['slug' => 'web-development', 'icon' => 'flaticon-code', 'image' => 'h4_services_img02.jpg', 'title_en' => 'Web Development', 'title_fr' => 'Développement Web', 'description_en' => 'Fast, secure websites and web apps built for performance.', 'description_fr' => 'Sites et applications web rapides et sécurisés.'],
            ['slug' => 'branding', 'icon' => 'flaticon-design', 'image' => 'h4_services_img03.jpg', 'title_en' => 'Branding & UI/UX', 'title_fr' => 'Branding & UI/UX', 'description_en' => 'Visual identity and user experiences that stand out.', 'description_fr' => 'Identité visuelle et expériences utilisateur qui se démarquent.'],
            ['slug' => 'marketing', 'icon' => 'flaticon-profit', 'image' => 'h4_services_img04.jpg', 'title_en' => 'Digital Marketing', 'title_fr' => 'Marketing Digital', 'description_en' => 'Paid media, SEO and content that drive measurable growth.', 'description_fr' => 'Publicité, SEO et contenu pour une croissance mesurable.'],
        ];

        foreach ($items as &$item) {
            $item['title']       = $item['title' . $suffix];
            $item['description'] = $item['description' . $suffix];
        }
        unset($item);

        return $items;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultTestimonials(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);
        $suffix = $locale === 'fr' ? '_fr' : '_en';

        $items = [
            [
                'img'       => 'temoignage_kamga.png',
                'name'      => 'Mr. Aristide KAMGA',
                'role_fr'   => 'Direction Générale, N2VTI',
                'role_en'   => 'General Direction, N2VTI',
                'quote_fr'  => 'Avant DB Digital Agency, nous avions peu d\'inscriptions. En quelques semaines, leur stratégie a boosté notre visibilité et attiré des candidats qualifiés. Nous recommandons vivement.',
                'quote_en'  => 'Before working with DB Digital Agency, we had few enrollments. Within weeks, their strategy boosted our visibility and attracted qualified applicants. We highly recommend them.',
            ],
            [
                'img'       => 'temoignage_kamagate.png',
                'name'      => 'ALLY Kamagaté',
                'role_fr'   => 'Administration, DM Academy Côte d\'Ivoire',
                'role_en'   => 'Administration, DM Academy Ivory Coast',
                'quote_fr'  => 'Nous cherchions une solution d\'inscriptions prévisible. DB Digital Agency nous a apporté une stratégie efficace, générant plus de prospects qualifiés et de conversions. Un partenaire clé de notre croissance.',
                'quote_en'  => 'We were looking for a predictable enrollment solution. DB Digital Agency delivered an effective strategy that increased qualified leads and conversions. A key partner in our growth.',
            ],
        ];

        foreach ($items as &$item) {
            $item['role']      = $item['role' . $suffix];
            $item['quote']     = $item['quote' . $suffix];
            $item['image_url'] = $this->testimonialImageUrl((string) $item['img']);
        }
        unset($item);

        return $items;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultTeam(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);

        $members = [
            ['img' => 'team_img_rose.png', 'name' => 'Eugénie Rose Yuoyang', 'role_key' => 'about_ceo'],
            ['img' => 'team_img_pascal.png', 'name' => 'Pierre Pascal Essomba', 'role_key' => 'team_role_graphic_designer'],
            ['img' => 'team_img_stephane.png', 'name' => 'Stephane Kamga', 'role_key' => 'team_role_dev'],
            ['img' => 'team_img_fabien.png', 'name' => 'Fabien Meboue', 'role_key' => 'about_dg_douala'],
            ['img' => 'team_img_delphine.png', 'name' => 'Delphine Mengue', 'role_key' => 'team_role_video_designer'],
            ['img' => 'team_img_lionel.png', 'name' => 'Lionel Dounia', 'role_key' => 'team_role_marketing_director'],
            ['img' => 'team_img_van.png', 'name' => 'Van Besong', 'role_key' => 'team_role_community_manager'],
            ['img' => 'team_img_ulrich.png', 'name' => 'Ulrich Fotso', 'role_key' => 'team_role_dev'],
        ];

        foreach ($members as &$member) {
            $member['image']     = $member['img'];
            $member['image_url'] = asset_url('img/team/' . $member['img']);
            $member['role']      = site_trans((string) $member['role_key'], $locale);
        }
        unset($member);

        return $members;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultBrandLogos(): array
    {
        $files = ['brand_img01.png', 'brand_img02.png', 'brand_img05.png', 'brand_img03.png', 'brand_img04.png'];

        return array_map(static fn ($f) => ['filename' => $f, 'url' => asset_url('img/brand/' . $f)], $files);
    }

    /**
     * @return list<array<string, mixed>>|null
     */
    protected function getHomepageSectionItems(string $key, string $locale): ?array
    {
        $data = $this->getHomepageSectionData($key, $locale);

        if (! is_array($data)) {
            return null;
        }

        return isset($data['items']) && is_array($data['items']) ? $data['items'] : $data;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getHomepageSectionData(string $key, string $locale): ?array
    {
        if (! DbGuard::available()) {
            return null;
        }

        $db = $this->serviceModel->db;
        if (! $db->tableExists('homepage_sections') || ! $db->tableExists('section_translations')) {
            return null;
        }

        $section = $db->table('homepage_sections')
            ->where('key', $key)
            ->where('is_active', 1)
            ->get()
            ->getRowArray();

        if ($section === null) {
            return null;
        }

        $row = $db->table('section_translations')
            ->where('section_id', (int) $section['id'])
            ->where('locale', $locale)
            ->get()
            ->getRowArray();

        if ($row === null || empty($row['data'])) {
            return null;
        }

        $decoded = json_decode((string) $row['data'], true);

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultBlogCategories(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);

        return [
            ['name' => $locale === 'fr' ? 'Stratégie' : 'Strategy', 'count' => 6],
            ['name' => 'Branding', 'count' => 4],
            ['name' => 'Web', 'count' => 6],
            ['name' => 'SEO', 'count' => 5],
            ['name' => $locale === 'fr' ? 'Publicité' : 'Paid Media', 'count' => 5],
            ['name' => $locale === 'fr' ? 'Analytique' : 'Analytics', 'count' => 3],
        ];
    }

    /**
     * @return list<array<string, string>>
     */
    protected function defaultBlogTags(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);

        return [
            ['name' => 'SEO'],
            ['name' => $locale === 'fr' ? 'Conversion' : 'Conversion'],
            ['name' => 'UI/UX'],
            ['name' => 'Ads'],
            ['name' => $locale === 'fr' ? 'Contenu' : 'Content'],
        ];
    }

    /**
     * @return list<array<string, string>>
     */
    protected function loadBlogTagsFromSettings(): array
    {
        if (! DbGuard::available()) {
            return [];
        }

        $db = $this->serviceModel->db;
        if (! $db->tableExists('site_settings')) {
            return [];
        }

        $row = $db->table('site_settings')
            ->where('setting_key', 'blog_tags')
            ->get()
            ->getRowArray();

        if ($row === null || empty($row['setting_value'])) {
            return [];
        }

        $decoded = json_decode((string) $row['setting_value'], true);

        return is_array($decoded) ? $decoded : [];
    }

    protected function defaultOffices(?string $locale = null): array
    {
        $locale = $this->resolveLocale($locale);

        return [
            ['key' => 'douala', 'city' => 'Douala', 'label_fr' => 'Cameroun · Douala', 'label_en' => 'Cameroon · Douala', 'address' => 'Cité des palmiers', 'phone' => '+237 691 323 249', 'email' => 'douala@dbdigitalagency.com', 'lat' => 4.048839, 'lng' => 9.704497, 'zoom' => 15, 'image' => 'contact_img_dla.png'],
            ['key' => 'yaounde', 'city' => 'Yaoundé', 'label_fr' => 'Cameroun · Yaoundé', 'label_en' => 'Cameroon · Yaoundé', 'address' => 'Nkoabang - Entrée Carrière', 'phone' => '+237 691 323 249', 'email' => 'yaounde@dbdigitalagency.com', 'lat' => 3.8514329, 'lng' => 11.5765658, 'zoom' => 15, 'image' => 'contact_img_yde.png'],
            ['key' => 'bafoussam', 'city' => 'Bafoussam', 'label_fr' => 'Cameroun · Bafoussam', 'label_en' => 'Cameroon · Bafoussam', 'address' => 'Kamkop (face station Tradex)', 'phone' => '+237 691 323 249', 'email' => 'bafoussam@dbdigitalagency.com', 'lat' => 5.500007, 'lng' => 10.388760, 'zoom' => 13, 'image' => 'contact_img_baf.png'],
        ];
    }

    protected function resolveLocale(?string $locale): string
    {
        if ($locale !== null && in_array($locale, ['fr', 'en'], true)) {
            return $locale;
        }

        return service('request')->getLocale();
    }
}
