<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasTypeAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasPlaceholderAttribute;

class Textarea extends Element
{
    use HasTypeAttribute;
    use InteractsWithForms;
    use HasPlaceholderAttribute;

    /**
     * @var string
     */
    protected $tag = 'textarea';

    /**
     * Textarea constructor.
     */
    public function __construct()
    {
        $this->disabledAttributes = ['value'];
    }
}
