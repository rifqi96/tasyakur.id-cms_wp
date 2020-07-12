<?php
get_header();

// Get categories list
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$catSlug = get_queried_object()->slug;
$postsPerpage = get_option('products_per_page');
if (!$postsPerpage || is_nan($postsPerpage))
    $postsPerpage = 10;
$args = [
    'posts_per_page' => $postsPerpage,
    'orderby' => 'date',
    'order' => 'ASC',
    'post_type' => 'products',
    'fields' => ['ID'],
    'tax_query' => [
        [
            'taxonomy' => 'products_category',
            'field' => 'slug',
            'terms' => $catSlug
        ]
    ],
    'paged' => $paged
];
set_query_var('args', $args);

// Get the title for search result
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
set_query_var('theTitle', $term->name ?? 'Products');

// Get the featured image
$featuredImage = get_field('featured_image', $term);
// Pass featured image
set_query_var('featuredImage', $featuredImage['url'] ?? false);

get_template_part('template-parts/archive', 'products');

get_footer();
?>