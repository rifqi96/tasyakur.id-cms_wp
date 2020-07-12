<?php
namespace Tasyakur\Providers\SvgEnabler\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class ShowSvgOnBrowser implements HooksInterface
{
    /**
     * Register the hook function
     *
     * @return void
     */
    public function init()
    {
        add_action('admin_enqueue_scripts', [$this, 'administrationStyles']);
        add_action('wp_head', [$this, 'publicStyles']);
    }

    /**
     * Browsers may or may not show SVG files properly without a height/width.
     * WordPress specifically defines width/height as "0" if it cannot figure it out.
     * Thus the below is needed.
     * Consider this the "client side" fix for dimensions. But only for the Administration.
     * WordPress requires inline administration styles to be wrapped in an actionable function.
     * These styles specifically address the Media Listing styling and Featured Image
     * styling so that the images show up in the Administration area.
     *
     * @return void
     */
    public function administrationStyles()
    {
        // Media Listing Fix
        wp_add_inline_style('wp-admin', ".media .media-icon img[src$='.svg'] { width: auto; height: auto; }");
        // Featured Image Fix
        wp_add_inline_style('wp-admin', "#postimagediv .inside img[src$='.svg'] { width: 100%; height: auto; }");
    }

    /**
     * Browsers may or may not show SVG files properly without a height/width.
     * WordPress specifically defines width/height as "0" if it cannot figure it out.
     * Thus the below is needed.
     * Consider this the "client side" fix for dimensions. But only for the End User.
     */
    public function publicStyles()
    {
        // Featured Image Fix
        echo "<style>.post-thumbnail img[src$='.svg'] { width: 100%; height: auto; }</style>";
    }
}