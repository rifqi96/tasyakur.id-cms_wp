<?php
require_once get_template_directory() . "/inc/Contracts/HooksInterface.php";

class MenuHook implements HooksInterface
{
    /**
     * MenuHook constructor.
     */
    public function __construct()
    {
    }

    public function init(): void
    {
        add_action( 'init', [$this, 'registerMenus'] );
        add_filter( 'nav_menu_css_class' , [$this, 'specialMainNavClass'] , 10 , 2);
        add_filter( 'wp_nav_menu_objects', [$this, 'addHasChildrenToMainNavItems'] );
    }

    /**
     * Registers menu
     */
    public function registerMenus()
    {
        register_nav_menus([
            'header-menu' => __('Header Menu'),
            'products-category-menu' => __('Products Category Menu'),
        ]);
    }

    /**
     * Changes default nav active class name
     *
     * @param $classes
     * @param $item
     * @return mixed
     */
    public function specialMainNavClass ($classes, $item)
    {
        if (in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
            $classes[] = 'active ';
        }
        return $classes;
    }

    /**
     * Adds has-children into parent li
     *
     * @param $items
     * @return mixed
     */
    public function addHasChildrenToMainNavItems( $items )
    {
        $parents = wp_list_pluck( $items, 'menu_item_parent');

        foreach ( $items as $item )
            in_array( $item->ID, $parents ) && $item->classes[] = 'has-children';

        return $items;
    }
}