<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasValueAttribute;

class Option extends Element
{
    use HasValueAttribute;

    /**
     * @var string
     */
    protected $tag = 'option';
}
