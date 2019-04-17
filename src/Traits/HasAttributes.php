<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait HasAttributes
{
    /**
     * @param string $key
     * @return string
     */
    protected function getInternalAttributeKey(string $key): string
    {
        return 'attribute'.Str::ucfirst($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasAttribute(string $key): bool
    {
        return property_exists($this, $this->getInternalAttributeKey($key));
    }

    /**
     * @param string $property
     * @return string
     */
    protected function convertPropertyNameToAttributeName(string $property): string
    {
        return Str::slug(Str::substr($property, 9), '-');
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getAttributeValidationMethod(string $key): string
    {
        return 'validate'.Str::ucfirst($key).'Attribute';
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasAttributeValidationMethod(string $key): bool
    {
        return method_exists($this, $this->getAttributeValidationMethod($key));
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getTransformInternalAttributeMethod(string $key): string
    {
        return 'transformInternal'.Str::ucfirst($key).'Attribute';
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasTransformInternalAttributeMethod(string $key): bool
    {
        return method_exists($this, $this->getTransformInternalAttributeMethod($key));
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getTransformOutputAttributeMethod(string $key): string
    {
        return 'transformOutput'.Str::ucfirst($key).'Attribute';
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasTransformOutputAttributeMethod(string $key): bool
    {
        return method_exists($this, $this->getTransformOutputAttributeMethod($key));
    }

    /**
     * @param string $name
     * @param $value
     * @return array|bool
     */
    protected function transformInternalAttribute(string $name, $value)
    {
        if (is_bool($value)) {
            return $this->{$name};
        }

        return is_array($this->{$name}) ? array_merge($this->{$name}, [$value]) : [$value];
    }

    /**
     * @param string $name
     * @param string $glue
     * @return string|bool
     */
    protected function transformOutputAttribute(string $name, string $glue = ' ')
    {
        return is_array($this->{$name}) && count($this->{$name}) ? implode($glue, $this->{$name}) : false;
    }

    /**
     * @param array $attributes
     * @param string|null $prefix
     * @return string
     */
    protected function buildAttributesString(array $attributes, $prefix = null): string
    {
        $string = [];

        $validAttributes = array_filter($attributes, function ($attribute) {
            return $attribute !== false;
        });

        $prefix = $prefix ? "{$prefix}-" : '';

        foreach ($validAttributes as $key => $value) {
            // True values mean that the attribute should be treated
            // as a non-value one like `required` or `checked`
            if ($value === true) {
                $string[] = $key;
            } else {
                $string[] = "{$prefix}{$key}=\"{$value}\"";
            }
        }

        return count($string) ? ' '.implode(' ', $string) : '';
    }

    /**
     * @return string
     */
    protected function getAttributesString(): string
    {
        $properties = get_object_vars($this);

        $attributes = [];

        foreach ($properties as $name => $value) {
            if (Str::startsWith($name, 'attribute')) {
                $attribute = $this->convertPropertyNameToAttributeName($name);

                $attributes[$attribute] =
                    $this->hasTransformOutputAttributeMethod($attribute) ?
                        $this->{$this->getTransformOutputAttributeMethod($attribute)}($value) : $value;
            }
        }

        return $this->buildAttributesString($attributes);
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
