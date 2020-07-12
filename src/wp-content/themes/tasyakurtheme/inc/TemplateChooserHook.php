<?php
require_once get_template_directory() . "/inc/Contracts/HooksInterface.php";

class TemplateChooserHook implements HooksInterface
{

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        add_filter('template_include', [$this, 'templateChooser']);
    }

    /**
     * Additional logic to choose which template to load from
     * @param $template
     * @return string
     */
    function templateChooser($template)
    {
        global $wp_query;
        $postType = get_query_var('post_type')[0] ?? 'post';
        if( $wp_query->is_search && $postType == 'products' )
        {
            return locate_template('archive-products-search.php');  //  redirect to archive-search.php
        }
        return $template;
    }
}