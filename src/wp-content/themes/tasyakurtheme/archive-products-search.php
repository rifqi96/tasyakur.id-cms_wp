<?php
get_header();

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
    's' => $s,
    'paged' => $paged
];
set_query_var('args', $args);
set_query_var('theTitle', "Search results for: <span class='font-italic'>$s</span> in products section");
get_template_part('template-parts/archive', 'products');

get_footer();
?>