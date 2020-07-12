<?php
namespace Tasyakur\Providers\PostTypeProducts;

use Tasyakur\Core\Contracts\ServiceProvider;
use Tasyakur\Providers\PostTypeProducts\Hooks\AddProductsPaginationSettingsField;
use Tasyakur\Providers\PostTypeProducts\Hooks\EnableProductsNavActiveClass;
use Tasyakur\Providers\PostTypeProducts\Hooks\RegisterProductsPostType;
use Tasyakur\Providers\PostTypeProducts\Hooks\RegisterProductsCategoryTaxonomy;

class PostTypeProducts extends ServiceProvider
{

    public function register()
    {
        $this->hooksLoader->addHooks(
            RegisterProductsPostType::class,
            RegisterProductsCategoryTaxonomy::class,
            AddProductsPaginationSettingsField::class,
            EnableProductsNavActiveClass::class,
        );
    }
}