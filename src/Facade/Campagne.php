<?php

namespace designpond\newsletter\Facade;

use Illuminate\Support\Facades\Facade;

class Campagne extends Facade {
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'newsworker'; // the IoC binding.
    }
}