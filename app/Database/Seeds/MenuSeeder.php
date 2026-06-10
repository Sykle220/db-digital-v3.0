<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    use LegacyConfigTrait;

    /** @var array<string, string> */
    protected array $legacyRouteMap = [
        'index.php'   => 'home',
        'about.php'   => 'about',
        'services.php' => 'services',
        'projects.php' => 'projects',
        'blog.php'    => 'blog',
        'contact.php' => 'contact',
    ];

    public function run(): void
    {
        if (! $this->db->tableExists('menus')) {
            return;
        }

        $this->loadLegacyConfig();

        $nav_items = $this->legacyVars()['nav_items'] ?? [];

        $menu = $this->db->table('menus')->where('key', 'header')->get()->getRowArray();
        if ($menu) {
            $menuId = (int) $menu['id'];
        } else {
            $this->db->table('menus')->insert([
                'key'  => 'header',
                'name' => 'Header Navigation',
            ]);
            $menuId = (int) $this->db->insertID();
        }

        $this->db->table('menu_items')->where('menu_id', $menuId)->delete();

        $sort = 0;
        foreach ($nav_items as $item) {
            $sort++;
            $legacyUrl = (string) ($item['url'] ?? '');
            $routeKey  = $this->legacyRouteMap[$legacyUrl] ?? 'home';

            $this->db->table('menu_items')->insert([
                'menu_id'      => $menuId,
                'parent_id'    => null,
                'sort_order'   => $sort,
                'type'         => 'route',
                'target_id'    => null,
                'url'          => $routeKey,
                'icon'         => null,
                'css_class'    => (string) ($item['class'] ?? ''),
                'is_active'    => 1,
                'open_new_tab' => 0,
            ]);

            $itemId = (int) $this->db->insertID();
            $labelKey = (string) ($item['label_key'] ?? '');

            foreach (['fr', 'en'] as $locale) {
                $label = $this->translationValue($labelKey, $locale) ?: $labelKey;

                $this->db->table('menu_item_translations')->insert([
                    'menu_item_id' => $itemId,
                    'locale'       => $locale,
                    'label'        => $label,
                ]);
            }
        }
    }

    protected function translationValue(string $key, string $locale): string
    {
        if ($key === '' || ! $this->db->tableExists('translation_keys')) {
            return '';
        }

        $row = $this->db->table('translation_keys tk')
            ->select('tv.value')
            ->join('translation_values tv', 'tv.key_id = tk.id', 'left')
            ->where('tk.key', $key)
            ->where('tv.locale', $locale)
            ->get()
            ->getRowArray();

        return (string) ($row['value'] ?? '');
    }
}
