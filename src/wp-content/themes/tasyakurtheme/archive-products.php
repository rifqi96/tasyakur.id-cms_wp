<?php
get_header();

// Get product posts list
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$postsPerpage = get_option('products_per_page');
if (!$postsPerpage || is_nan($postsPerpage))
    $postsPerpage = 10;
$args = [
    'posts_per_page' => $postsPerpage,
    'orderby' => 'date',
    'order' => 'ASC',
    'post_type' => 'products',
    'fields' => ['ID'],
    'paged' => $paged
];
set_query_var('args', $args);

// Get the featured image
$page = get_page_by_path('products');
$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID), 'thumbnail');
// Pass featured image
set_query_var('featuredImage', $featuredImage[0] ?? false);

// Load the template
get_template_part('template-parts/archive', 'products');

get_footer();
?>