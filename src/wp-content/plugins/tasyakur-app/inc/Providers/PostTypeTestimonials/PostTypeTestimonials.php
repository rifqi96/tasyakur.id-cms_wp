<?php
namespace Tasyakur\Providers\PostTypeTestimonials;

use Tasyakur\Providers\PostTypeTestimonials\Hooks\AddTestimonialsPaginationSettingsField;
use Tasyakur\Providers\PostTypeTestimonials\Hooks\EnableTestimonialsNavActiveClass;
use Tasyakur\Providers\PostTypeTestimonials\Hooks\RegisterTestimonialsPostType;

class PostTypeTestimonials extends \Tasyakur\Core\Contracts\ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->hooksLoader->addHooks(
            RegisterTestimonialsPostType::class,
            AddTestimonialsPaginationSettingsField::class,
            EnableTestimonialsNavActiveClass::class,
        );
    }
}