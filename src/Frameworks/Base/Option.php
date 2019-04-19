<?php

namespace ionesculiviucristian\LaravelHtmlForms\Frameworks\Base;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasValueAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasDisabledAttribute;

/**
 * @property bool $selected
 *
 * @method self selected(bool $value)
 */
class Option extends Element
{
    use HasValueAttribute;
    use HasDisabledAttribute;

    /**
     * @var bool
     */
    protected $attributeSelected = false;

    /**
     * @var string
     */
    protected $tag = 'option';

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalSelectedAttribute($value): bool
    {
        return (bool) $value;
    }
}
