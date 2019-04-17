<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

use Illuminate\Support\Str;

trait HasDataAttributes
{
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
}
