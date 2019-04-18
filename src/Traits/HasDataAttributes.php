<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait HasDataAttributes
{
    /**
     * @var array
     */
    protected $dataAttributes = [];

    /**
     * @param string $key
     * @return string
     */
    protected function getInternalDataAttributeKey(string $key): string
    {
        return lcfirst(Str::substr($key, 4));
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasDataAttribute(string $key): bool
    {
        return array_key_exists($this->getInternalDataAttributeKey($key), $this->dataAttributes);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isDataAttribute(string $key): bool
    {
        return Str::startsWith($key, 'data');
    }

    /**
     * @param mixed $value
     */
    protected function validateDataAttributeValue($value): void
    {
        if (is_bool($value)) {
            return;
        }

        if (! is_scalar($value)) {
            throw new InvalidArgumentException('Only scalar values can be passed to data attributes.');
        }
    }
}
