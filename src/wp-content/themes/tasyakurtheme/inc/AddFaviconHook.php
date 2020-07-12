<?php
require_once get_template_directory() . "/inc/Contracts/HooksInterface.php";

class AddFaviconHook implements HooksInterface
{

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        add_action('wp_head', [$this, 'addFavicon']);
    }

    /**
     * Adds favicon to the site
     */
    function addFavicon()
    {
        ?>
        <!-- Custom Favicons -->
        <link rel="shortcut icon" href="<?=get_template_directory_uri()?>/images/favicon.ico"/>
        <link rel="apple-touch-icon" href="<?=get_template_directory_uri(); ?>/images/apple-touch-icon.png">
        <?php
    }
}