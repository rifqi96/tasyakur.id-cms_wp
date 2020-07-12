<?php
namespace Tasyakur\Providers\PostTypeProducts\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class RegisterProductsPostType implements HooksInterface
{
    public const POST_TYPE_NAME = 'products';

    public function init()
    {
        add_action('init', [$this, 'registerPostType']);
    }
    
    public function registerPostType()
    {
        $labels = [
            'name' => 'Products',
            'singular_name' => 'Product',
            'menu_name' => 'Products',
            'add_new' => _x('Post New', 'product'),
            'add_new_item' => 'Post A New Product',
            'new_item' => 'New Product',
            'view_item' => 'View Product',
            'view_items' => 'View Products',
            'search_items' => 'Search Products',
            'not_found' => 'No products found',
            'not_found_in_trash' => 'No products found in a Trash',
            'all_items' => 'All Products',
            'archives' => 'Product Archives',
            'attributes' => 'Product Attributes',
            'insert_into_item' => 'Insert into product',
            'uploaded_to_this_item' => 'Uploaded to this product',
        ];

        $customPostTypeProps = [
            'labels' => $labels,
            'public' => true,
            'menu_position' => 4,
            'capability_type' => 'post',
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'revisions', 'thumbnail'),
            'taxonomies' => [ RegisterProductsCategoryTaxonomy::TAXO_NAME ],
            // 'with_front' => false,
            'rewrite' => [
                'slug' => static::POST_TYPE_NAME,
                'with_front' => false,
                'feed'=> true,
                'pages'=> true,
            ],
            // Items below are to disable the permalink
            // 'public'             => false,  // it's not public, it shouldn't have it's own permalink, and so on
            // 'publicly_queryable' => true,  // you should be able to query it
            'show_ui' => current_user_can('administrator'),  // only administrator role should be able to edit it in wp-admin
            // 'exclude_from_search'=> true,  // you should exclude it from search results
            // 'show_in_nav_menus'  => false,  // you shouldn't be able to add it to menus
            // 'has_archive'        => false,  // it shouldn't have archive page
            // 'rewrite'            => false,  // it shouldn't have rewrite rules
        ];

        // Register Products Custom Post Type
        register_post_type(static::POST_TYPE_NAME, $customPostTypeProps);
        // Change title label
        add_filter('enter_title_here', [$this, 'setTitleText']);
        // Register thumbnail
        add_theme_support('post-thumbnails');
    }

    /**
     * @param string $title
     * @return string
     */
    public function setTitleText($title)
    {
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;

        if (isset($screen->post_type) && $screen->post_type === 'products')
            $title = 'Enter Product Name Here';

        return $title;
    }
}