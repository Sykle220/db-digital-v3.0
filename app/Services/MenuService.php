<?php

namespace App\Services;

use App\Libraries\DbGuard;
use App\Models\MenuItemModel;
use App\Models\MenuModel;

class MenuService
{
    protected MenuModel $menuModel;
    protected MenuItemModel $itemModel;

    public function __construct(?MenuModel $menuModel = null, ?MenuItemModel $itemModel = null)
    {
        $this->menuModel = $menuModel ?? model(MenuModel::class);
        $this->itemModel = $itemModel ?? model(MenuItemModel::class);
    }

    /**
     * Construit l'arbre de menu pour une clé et une locale.
     *
     * @return list<array<string, mixed>>
     */
    public function buildTree(string $menuKey, ?string $locale = null): array
    {
        return DbGuard::run(function () use ($menuKey, $locale) {
            $locale = $this->resolveLocale($locale);
            $menu   = $this->menuModel->where('key', $menuKey)->first();

            if ($menu === null) {
                return [];
            }

            $items = $this->itemModel
                ->where('menu_id', $menu['id'])
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->findAll();

            if ($items === []) {
                return [];
            }

            $itemIds = array_column($items, 'id');
            $labels  = $this->loadLabels($itemIds, $locale);

            $indexed = [];
            foreach ($items as $item) {
                $item['label']    = $labels[$item['id']] ?? '';
                $item['url']      = $this->resolveItemUrl($item, $locale);
                $item['children'] = [];
                $indexed[$item['id']] = $item;
            }

            $tree = [];
            foreach ($indexed as $id => &$node) {
                $parentId = $node['parent_id'];
                if ($parentId !== null && isset($indexed[$parentId])) {
                    $indexed[$parentId]['children'][] = &$node;
                } else {
                    $tree[] = &$node;
                }
            }
            unset($node);

            return $tree;
        }, []);
    }

    /**
     * Rend le HTML d'un menu.
     */
    public function render(string $menuKey, ?string $locale = null, array $options = []): string
    {
        $tree      = $this->buildTree($menuKey, $locale);
        $ulClass   = $options['ul_class'] ?? 'list-wrap';
        $liClass   = $options['li_class'] ?? '';
        $linkClass = $options['link_class'] ?? '';
        $depth     = (int) ($options['depth'] ?? 0);

        return $this->renderNodes($tree, $ulClass, $liClass, $linkClass, $depth);
    }

    /**
     * @param list<array<string, mixed>> $nodes
     */
    protected function renderNodes(array $nodes, string $ulClass, string $liClass, string $linkClass, int $depth): string
    {
        if ($nodes === []) {
            return '';
        }

        $html = '<ul class="' . esc($ulClass, 'attr') . '">';
        foreach ($nodes as $node) {
            $classes = trim($liClass . ' ' . ($node['css_class'] ?? ''));
            $html .= '<li' . ($classes !== '' ? ' class="' . esc($classes, 'attr') . '"' : '') . '>';

            $href   = (string) ($node['url'] ?? '#');
            $label  = (string) ($node['label'] ?? '');
            $target = ! empty($node['open_new_tab']) ? ' target="_blank" rel="noopener noreferrer"' : '';

            $html .= '<a href="' . esc($href, 'attr') . '" class="' . esc($linkClass, 'attr') . '"' . $target . '>'
                . esc($label) . '</a>';

            if (! empty($node['children'])) {
                $html .= $this->renderNodes($node['children'], $ulClass, $liClass, $linkClass, $depth + 1);
            }

            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * @param list<int> $itemIds
     *
     * @return array<int, string>
     */
    protected function loadLabels(array $itemIds, string $locale): array
    {
        if ($itemIds === []) {
            return [];
        }

        $rows = $this->itemModel->db->table('menu_item_translations')
            ->whereIn('menu_item_id', $itemIds)
            ->where('locale', $locale)
            ->get()
            ->getResultArray();

        $labels = [];
        foreach ($rows as $row) {
            $labels[(int) $row['menu_item_id']] = (string) $row['label'];
        }

        return $labels;
    }

    /**
     * @param array<string, mixed> $item
     */
    protected function resolveItemUrl(array $item, string $locale): string
    {
        $type = (string) ($item['type'] ?? 'url');

        return match ($type) {
            'page' => $this->resolvePageUrl((int) ($item['target_id'] ?? 0), $locale),
            'route' => page_url((string) ($item['url'] ?? ''), $locale),
            default => (string) ($item['url'] ?? '#'),
        };
    }

    protected function resolvePageUrl(int $pageId, string $locale): string
    {
        if ($pageId <= 0) {
            return '#';
        }

        $row = $this->menuModel->db->table('page_translations')
            ->select('slug')
            ->where('page_id', $pageId)
            ->where('locale', $locale)
            ->get()
            ->getRowArray();

        if ($row === null) {
            return '#';
        }

        return page_url((string) $row['slug'], $locale);
    }

    protected function resolveLocale(?string $locale): string
    {
        if ($locale !== null && in_array($locale, ['fr', 'en'], true)) {
            return $locale;
        }

        return service('request')->getLocale();
    }
}
