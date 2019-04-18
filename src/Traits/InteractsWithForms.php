<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * @property string|bool $name
 * @property string|bool $autocomplete
 * @property bool $required
 * @property bool $readonly
 * @property bool $autofocus
 *
 * @method self name(string|bool $value)
 * @method self autocomplete(string|bool $value)
 * @method self required(bool $value)
 * @method self readonly(bool $value)
 * @method self autofocus(bool $value)
 */
trait InteractsWithForms
{
    use HasTypeAttribute;
    use HasValueAttribute;
    use HasDisabledAttribute;

    /**
     * @var string
     */
    protected $attributeName = false;

    /**
     * @var string
     */
    protected $attributeAutocomplete = false;

    /**
     * @var bool
     */
    protected $attributeRequired = false;

    /**
     * @var bool
     */
    protected $attributeReadonly = false;

    /**
     * @var bool
     */
    protected $attributeAutofocus = false;

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalRequiredAttribute($value): bool
    {
        return (bool) $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalReadonlyAttribute($value): bool
    {
        return (bool) $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function transformInternalAutofocusAttribute($value): bool
    {
        return (bool) $value;
    }

    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    protected function validateAutocompleteAttribute($value): void
    {
        if (is_bool($value)) {
            return;
        }

        if (! in_array(Str::lower($value), ['on', 'off'])) {
            throw new InvalidArgumentException("{$value} is not a valid type attribute.");
        }
    }
}
