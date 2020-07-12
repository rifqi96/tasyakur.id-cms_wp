<?php
namespace Tasyakur\Providers\PostTypeProducts\Hooks;

class EnableProductsNavActiveClass implements \Tasyakur\Core\Contracts\HooksInterface
{

    /**
     * @inheritDoc
     */
    public function init()
    {
        add_filter( 'nav_menu_css_class', [ $this, 'navParentClass' ], 10, 2 );
    }

    public function navParentClass( $classes, $item )
    {
        if ( RegisterProductsPostType::POST_TYPE_NAME == get_post_type() && ! is_admin() ) {
            global $wpdb;

            // remove any active classes from nav (blog is usually gets the currept_page_parent class on cpt single pages/posts)
            $classes = array_filter($classes, function ( $class ) {
                return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item' ? false : true );
            });

            // get page info
            // - we really just want the post_name so it cane be compared to the post type slug
            $page = get_page_by_title( $item->title, OBJECT, 'page' );

            // check if slug matches post_name
            if( $page && $page->post_name == RegisterProductsPostType::POST_TYPE_NAME ) {
                // $classes[] = 'current_page_parent';
                $classes[] = 'current-menu-item';
            }

        }

        return $classes;
    }
}