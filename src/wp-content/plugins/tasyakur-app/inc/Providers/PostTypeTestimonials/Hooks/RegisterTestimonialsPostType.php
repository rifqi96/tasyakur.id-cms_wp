<?php
namespace Tasyakur\Providers\PostTypeTestimonials\Hooks;

class RegisterTestimonialsPostType implements \Tasyakur\Core\Contracts\HooksInterface
{
    public const POST_TYPE_NAME = 'testimonials';

    /**
     * @inheritDoc
     */
    public function init()
    {
        add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType()
    {
        $labels = [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
            'menu_name' => 'Testimonials',
            'add_new' => _x('Post New', 'testimonial'),
            'add_new_item' => 'Post A New Testimonial',
            'new_item' => 'New Testimonial',
            'view_item' => 'View Testimonial',
            'view_items' => 'View Testimonials',
            'search_items' => 'Search Testimonials',
            'not_found' => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in a Trash',
            'all_items' => 'All Testimonials',
            'archives' => 'Testimonial Archives',
            'attributes' => 'Testimonial Attributes',
            'insert_into_item' => 'Insert into testimonial',
            'uploaded_to_this_item' => 'Uploaded to this testimonial',
        ];

        $customPostTypeProps = [
            'labels' => $labels,
            'public' => true,
            'menu_position' => 6,
            'capability_type' => 'post',
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'thumbnail'),
            'rewrite' => [
                'slug' => static::POST_TYPE_NAME,
                'with_front' => false,
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

        // Register Testimonials Custom Post Type
        register_post_type(static::POST_TYPE_NAME, $customPostTypeProps);
        // Register thumbnail
        add_theme_support('post-thumbnails');
    }
}