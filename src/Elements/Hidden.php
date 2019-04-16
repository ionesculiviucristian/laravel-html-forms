<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\IsClosedInputTag;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasTypeAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;

class Hidden extends Element
{
    use IsClosedInputTag;
    use HasTypeAttribute;
    use InteractsWithForms;

    /**
     * Hidden constructor.
     */
    public function __construct()
    {
        $this->setAsClosedInputTag();

        $this->attributeType = 'hidden';
    }
}
