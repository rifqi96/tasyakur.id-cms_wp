<?php
namespace Tasyakur\Providers\SettingsContact\Hooks;

class RegisterContactOption implements \Tasyakur\Core\Contracts\HooksInterface
{
    public const MENU_SLUG = 'contact-settings-admin';

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * @inheritDoc
     */
    public function init()
    {
        add_action( 'admin_menu', array( $this, 'addSettingsPage' ) );
        add_action( 'admin_init', array( $this, 'pageInit' ) );
    }

    /**
     * Add options page
     */
    public function addSettingsPage()
    {
        // This page will be under "Settings"
        add_options_page(
            'Contact Settings',
            'Contact Settings',
            'manage_options',
            static::MENU_SLUG,
            array( $this, 'createAdminPage' )
        );
    }

    /**
     * Options page callback
     */
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option( 'contact' );
        ?>
        <div class="wrap">
            <h1>Contact Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'contact_group' );
                do_settings_sections( static::MENU_SLUG );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function pageInit()
    {
        $sectionId = 'contact_section';

        register_setting(
            'contact_group', // Option group
            'contact', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            $sectionId, // ID
            '', // Title
            array( $this, 'printSectionInfo' ), // Callback
            static::MENU_SLUG // Page
        );

        add_settings_field(
            'wa_no', // ID
            'Whatsapp No', // Title
            array( $this, 'waNoCallback' ), // Callback
            static::MENU_SLUG, // Page
            $sectionId // Section
        );

        add_settings_field(
            'wa_message', // ID
            'Whatsapp Message', // Title
            array( $this, 'waMessageCallback' ), // Callback
            static::MENU_SLUG, // Page
            $sectionId // Section
        );

        add_settings_field(
            'instagram',
            'Instagram',
            [$this, 'instagramCallback'],
            static::MENU_SLUG,
            $sectionId
        );

        add_settings_field(
            'facebook',
            'Facebook',
            [$this, 'facebookCallback'],
            static::MENU_SLUG,
            $sectionId,
        );

        add_settings_field(
            'address',
            'Address',
            [$this, 'addressCallback'],
            static::MENU_SLUG,
            $sectionId,
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['wa_no'] ) )
            $new_input['wa_no'] = sanitize_text_field( $input['wa_no'] );

        if( isset( $input['wa_message'] ) )
            $new_input['wa_message'] = sanitize_text_field( $input['wa_message'] );

        if( isset( $input['instagram'] ) )
            $new_input['instagram'] = sanitize_text_field( $input['instagram'] );

        if( isset( $input['facebook'] ) )
            $new_input['facebook'] = sanitize_text_field( $input['facebook'] );

        if( isset( $input['address'] ) )
            $new_input['address'] = sanitize_text_field( $input['address'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function printSectionInfo()
    {
        print 'Please fill up the form below';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function waNoCallback()
    {
        printf(
            '<input type="text" id="wa_no" name="contact[wa_no]" value="%s" placeholder="Format: 62xxxxx"/>',
            isset( $this->options['wa_no'] ) ? esc_attr( $this->options['wa_no']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function waMessageCallback()
    {
        printf(
            '<textarea id="wa_message" name="contact[wa_message]" placeholder="Message format for whatsapp" cols="30" rows="10">%s</textarea>',
            isset( $this->options['wa_message'] ) ? esc_attr( $this->options['wa_message']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function instagramCallback()
    {
        printf(
            '<input type="text" id="instagram" name="contact[instagram]" value="%s" placeholder="Instagram Username"/>',
            isset( $this->options['instagram'] ) ? esc_attr( $this->options['instagram']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function facebookCallback()
    {
        printf(
            '<input type="text" id="facebook" name="contact[facebook]" value="%s" placeholder="Full facebook page url"/>',
            isset( $this->options['facebook'] ) ? esc_attr( $this->options['facebook']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function addressCallback()
    {
        printf(
            '<textarea id="address" name="contact[address]" placeholder="Your store address" cols="30" rows="10">%s</textarea>',
            isset( $this->options['address'] ) ? esc_attr( $this->options['address']) : ''
        );
    }
}