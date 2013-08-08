<?php

namespace Spescina\Seorules\Facades;

use Illuminate\Support\Facades\Facade;

class Seo extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'seo'; }

}