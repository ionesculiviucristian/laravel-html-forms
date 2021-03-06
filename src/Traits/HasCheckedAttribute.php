<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

/**
 * @property bool $checked
 *
 * @method self checked(bool $value)
 */
trait HasCheckedAttribute
{
    /**
     * @var string
     */
    protected $attributeChecked = false;

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalCheckedAttribute($value): bool
    {
        return (bool) $value;
    }
}
