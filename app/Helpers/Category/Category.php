<?php
namespace App\Helpers\Category;

use App;
use App\Helpers\Container;

class Category
{

    public static string $tpl;

    public static function getMenu(string $tpl, string $cacheKey = '')
    {
        self::$tpl = $tpl;
        if ($cacheKey) {
            $menu_html = cache($cacheKey, '');
            if ($menu_html) {
                return $menu_html;
            }
        }
        $categories_data = self::getCategories();
        $categories_tree = self::getTree($categories_data);
        $menu_html = self::getHtml($categories_tree);
        if ($cacheKey) {
            cache([$cacheKey => $menu_html], now()->addDay());
        }
        return $menu_html;
    }
    public static function getTree($data): array
    {
        $categories_tree = [];
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $categories_tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['children'][$id] = &$node;
            }
        }
        return $categories_tree;
    }
    public static function getHtml(array $tree, $tab = ''): string
    {
        $str = '';
        foreach ($tree as $id => $item) {
            $str .= self::item2Tpl($item, $tab, $id);
        }
        return $str;
    }

    public static function item2Tpl($item, $tab, $id): string
    {
        return view(self::$tpl, ['item' => $item, 'tab' => $tab, 'id' => $id])->render();
    }

    public static function getCategories()
    {
        $categories_data = Container::get('categories_data');
        if (!$categories_data) {
            $categories_data = App\Models\Category::all()->keyBy('id')->toArray();
            Container::set('categories_data', $categories_data);
        }
        return $categories_data;
    }
    public static function getIds(int $category_id): string
    {
        $categories = self::getCategories(); // all categories
        $ids = '';

        foreach ($categories as $category) {
            if ($category['parent_id'] == $category_id) {
                $ids .= $category['id'] . ',';
                $ids .= self::getIds($category['id']); 
            }
        }
        return $ids;
    }

}
