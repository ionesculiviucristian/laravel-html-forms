<?php

namespace ionesculiviucristian\LaravelHtmlForms\Facades;

use Illuminate\Support\Facades\Facade;

class Select extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'select'; }
}
