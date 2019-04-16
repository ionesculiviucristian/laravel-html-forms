<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * @property string|bool $name
 * @property string|bool $autocomplete
 * @property bool $required
 * @property bool $disabled
 * @property bool $readonly
 *
 * @method self name(string|bool $value)
 * @method self autocomplete(string|bool $value)
 * @method self required(bool $value)
 * @method self disabled(bool $value)
 * @method self readonly(bool $value)
 */
trait InteractsWithForms
{
    use HasTypeAttribute;
    use HasValueAttribute;

    /**
     * @var string
     */
    protected $attributeName = false;

    /**
     * @var string
     */
    protected $attributeAutocomplete = false;

    /**
     * @var string
     */
    protected $attributeRequired = false;

    /**
     * @var string
     */
    protected $attributeDisabled = false;

    /**
     * @var string
     */
    protected $attributeReadonly = false;

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
