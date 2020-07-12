<?php

namespace Tasyakur\Setup;

use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Setup\Hooks\{AddPostTemplateToPostsList,
    ChangeEmailDefaultContentType,
    ChangeEmailSendFrom,
    ChangePasswordResetEmailSubject,
    CustomExcerptLength,
    DisableImageEditor,
    HideACF,
    NotFoundRedirect,
    RegisterPostRegion,
    RemoveCommentsOnPostsListTable,
    RemoveStaticFrontPage,
    RemoveWPImageSizes,
    RenameTagsToTopics,
    ReorderPostSubmenu,
    ThemeSetups\Background,
    ThemeSetups\HideAdminBar,
    ThemeSetups\Logo};

class Setup extends ServiceProvider
{

    /**
     * {@inheritDoc}
     * @see ServiceProvider::register()
     */
    public function register()
    {
        add_action('after_setup_theme', [$this, 'setup']);

        $this->hooksLoader->addHooks(
             ChangeEmailSendFrom::class,
            ChangePasswordResetEmailSubject::class,
            ChangeEmailDefaultContentType::class,
            CustomExcerptLength::class,
            // HideACF::class,
            RemoveCommentsOnPostsListTable::class,
        );
    }

    /**
     * Call the hooks and filters within after_setup_theme action
     * Load the required dependencies
     *
     * @return void
     */
    public function setup()
    {
        load_theme_textdomain('tasyakur');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');

        $this->hooksLoader->addHooks(
            HideAdminBar::class,
        );
    }
}