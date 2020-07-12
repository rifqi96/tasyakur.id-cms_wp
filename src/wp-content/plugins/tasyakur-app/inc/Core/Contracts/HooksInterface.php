<?php

namespace Tasyakur\Core\Contracts;

interface HooksInterface
{
    /**
     * Register the hook function
     *
     * @return void
     */
    public function init();
}