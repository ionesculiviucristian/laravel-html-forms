<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

/**
 * @property bool $disabled
 *
 * @method self disabled(bool $value)
 */
trait HasDisabledAttribute
{
    /**
     * @var string
     */
    protected $attributeDisabled = false;

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalDisabledAttribute($value): bool
    {
        return (bool) $value;
    }
}
