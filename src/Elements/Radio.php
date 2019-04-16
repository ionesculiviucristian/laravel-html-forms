<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasTypeAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\IsClosedInputTag;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasCheckedAttribute;

class Radio extends Element
{
    use IsClosedInputTag;
    use HasTypeAttribute;
    use InteractsWithForms;
    use HasCheckedAttribute;

    /**
     * Radio constructor.
     */
    public function __construct()
    {
        $this->setAsClosedInputTag();

        $this->attributeType = 'radio';
    }
}
