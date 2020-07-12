<?php
namespace Tasyakur\Providers\PostTypeTestimonials\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class AddTestimonialsPaginationSettingsField implements HooksInterface
{
    private $id;

    private $option;

    private $title;

    /**
     * AddTestimonialsPaginationSettingsField constructor.
     */
    public function __construct()
    {
        $this->id = 'testimonials_per_page';
        $this->title = 'Testimonial pages show at most';
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
            [$this, 'testimonialsPerPageCallback'],
            'reading',
        );

        register_setting('reading', $this->id, 'esc_attr');
    }

    public function testimonialsPerPageCallback()
    {
        printf(
            '<input type="number" class="small-text" step="1" min="1" id="'. $this->id .'" name="'. $this->id .'" value="%s"/> testimonials',
            isset( $this->option ) ? esc_attr( $this->option ) : ''
        );
    }
}