<?php

namespace ionesculiviucristian\LaravelHtmlForm;

/**
 * @property string|bool $type
 * @property string|bool $value
 *
 * @method Button type(string|bool $value)
 * @method Button value(string|bool $value)
 */
class Button extends Element
{
    /**
     * @var string
     */
    protected $tag = 'button';

    /**
     * @var array
     */
    protected $customAttributes = [
        'type'  => 'button',
        'value' => 'Button',
    ];
}
