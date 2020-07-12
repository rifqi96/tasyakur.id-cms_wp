<?php
/**
 * This file acts like normal functions.php
 *
 */

/**
 * Outputs pagination bar from wp query
 * @param WP_Query|null $query
 * @param int $range Additional. The length of numbers besides current page number.
 * @return void
 */
function pagination(WP_Query $query = null, int $range = 5): void
{
    $showitems = ($range * 2)+1;

    global $paged;
    if(empty($paged)) $paged = 1;

    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }
    $pages = $query->max_num_pages;

    if(!$pages)
    {
        $pages = 1;
    }

    if(1 != $pages)
    {
        echo "<div class='custom-pagination'>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
            }
        }

        if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
        echo "</div>\n";
    }
}

/**
 * Stops wordpress to redirect to the nearest similar url
 */
remove_filter('template_redirect', 'redirect_canonical');

/**
 * Uncomment code below to flush rewrite rule, and don't forget to comment it back out
 * or else it will get triggered on load which could slow down the performance
 */
// flush_rewrite_rules();