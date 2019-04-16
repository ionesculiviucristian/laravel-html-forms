<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use Illuminate\Support\Str;
use InvalidArgumentException;
use ionesculiviucristian\LaravelHtmlForms\Element;

/**
 * @property string|bool $action
 * @property string|bool $method
 * @property string|bool $enctype
 *
 * @method Form action(string|bool $value)
 * @method Form method(string|bool $value)
 * @method Form enctype(string|bool $value)
 */
class Form extends Element
{
    /**
     * @var string
     */
    protected $tag = 'form';

    /**
     * @var bool
     */
    protected $closeTag = false;

    /**
     * @var string|bool
     */
    protected $attributeAction = false;

    /**
     * @var string|bool
     */
    protected $attributeMethod = false;

    /**
     * @var string|bool
     */
    protected $attributeEnctype = false;

    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    protected function validateEnctypeAttribute($value): void
    {
        if (is_bool($value)) {
            return;
        }

        if (! in_array(Str::lower($value), ['application/x-www-form-urlencoded', 'multipart/form-data', 'text/plain'])) {
            throw new InvalidArgumentException("{$value} is not a valid type attribute.");
        }
    }

    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    protected function validateMethodAttribute($value): void
    {
        if (is_bool($value)) {
            return;
        }

        if (! in_array(Str::lower($value), ['get', 'post'])) {
            throw new InvalidArgumentException("{$value} is not a valid type attribute.");
        }
    }
}
