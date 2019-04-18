<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

/**
 * @property bool $multiple
 *
 * @method self multiple(bool $value)
 */
trait HasMultipleAttribute
{
    /**
     * @var string
     */
    protected $attributeMultiple = false;

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalMultipleAttribute($value): bool
    {
        return (bool) $value;
    }
}
