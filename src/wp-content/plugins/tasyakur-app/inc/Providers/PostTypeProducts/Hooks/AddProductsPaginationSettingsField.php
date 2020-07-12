<?php
namespace Tasyakur\Providers\PostTypeProducts\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class AddProductsPaginationSettingsField implements HooksInterface
{
    private $id;

    private $option;

    private $title;

    /**
     * AddProductsPaginationSettingsField constructor.
     */
    public function __construct()
    {
        $this->id = 'products_per_page';
        $this->title = 'Product pages show at most';
        $this->option = get_option( $this->id );
    }

    public function init()
    {
        add_action('admin_init', [$this, 'addSettingsField']);
    }

    public function addSettingsField()
    {
        add_settings_field(
            $this->id,
            $this->title,
            [$this, 'productsPerPageCallback'],
            'reading',
        );

        register_setting('reading', $this->id, 'esc_attr');
    }

    public function productsPerPageCallback()
    {
        printf(
            '<input type="number" class="small-text" step="1" min="1" id="'. $this->id .'" name="'. $this->id .'" value="%s"/> products',
            isset( $this->option ) ? esc_attr( $this->option ) : ''
        );
    }
}