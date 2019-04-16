<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use Illuminate\Support\Str;
use InvalidArgumentException;
use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasTypeAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\IsClosedInputTag;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;

class Button extends Element
{
    use IsClosedInputTag;
    use HasTypeAttribute;
    use InteractsWithForms;

    /**
     * Button constructor.
     */
    public function __construct()
    {
        $this->setAsClosedInputTag();

        $this->attributeType = 'button';
    }

    /**
     * @param string|bool $value
     * @throws InvalidArgumentException
     */
    protected function validateTypeAttribute($value): void
    {
        if (is_bool($value)) {
            return;
        }

        if (! in_array(Str::lower($value), ['button', 'reset', 'submit'])) {
            throw new InvalidArgumentException("{$value} is not a valid type attribute.");
        }
    }
}
