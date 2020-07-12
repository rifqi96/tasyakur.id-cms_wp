<?php
namespace Tasyakur\Providers\PostTypeProducts\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class RegisterProductsCategoryTaxonomy implements HooksInterface
{
    public const TAXO_NAME = 'products_category';

    public function init()
    {
        add_action('init', [$this, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
        /* ===================================
        *     Hierarchical Taxonomies
        * ===================================
        */
        // Post Product Categories
        $labels = [
            'name' => 'Product Categories',
            'singular_name' => 'Product Category',
            'all_items' => 'All Product Categories',
            'new_item_name' => 'New Product Category',
            'add_new_item' => 'Add New Product Category',
            'edit_item' => 'Edit Product Category',
            'update_item' => 'Update Product Category',
            'search_items' => 'Search Product Categories',
            'not_found' => 'No Product Category found',
            'parent_item' => 'Parent Product Category',
            'parent_item_colon' => 'Parent Product Category:',
            'menu_name' => 'Product Categories'
        ];

        $args = [
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            // 'with_front' => false,
            'rewrite' => [
                'slug' => static::TAXO_NAME,
                'has_archive' => true,
                'with_front' => false,
            ],
            'show_in_rest' => true,
            'rest_base' => 'product_categories',
        ];

        register_taxonomy(static::TAXO_NAME, RegisterProductsPostType::POST_TYPE_NAME, $args);
    }
}