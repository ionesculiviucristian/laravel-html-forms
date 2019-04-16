<?php

namespace ionesculiviucristian\LaravelHtmlForms;

use Exception;
use RuntimeException;
use BadMethodCallException;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * @property string|bool $id
 * @property string|bool $class
 * @property string|bool $title
 * @property string|bool $style
 *
 * @method Element id(string|bool $value)
 * @method Element class(string|bool $value)
 * @method Element title(string|bool $value)
 * @method Element style(string|bool $value)
 */
abstract class Element
{
    /**
     * @var string
     */
    protected $tag;

    /**
     * @var bool
     */
    protected $closeTag = true;

    /**
     * @return string|bool
     */
    protected $content;

    /**
     * @var string
     */
    protected $attributeTitle = false;

    /**
     * @var string
     */
    protected $attributeId = false;

    /**
     * @var string
     */
    protected $attributeClass = false;

    /**
     * @var string
     */
    protected $attributeStyle = false;

    /**
     * @var array
     */
    protected $dataAttributes = [];

    /**
     * @param string $tag
     * @return Element
     */
    public function setTag(string $tag): Element
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param bool $closeTag
     * @return Element
     */
    public function setCloseTag(bool $closeTag): Element
    {
        $this->closeTag = $closeTag;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCloseTag(): bool
    {
        return $this->closeTag;
    }

    /**
     * @param string $content
     * @return Element
     */
    public function setContent(string $content): Element
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

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
    protected function getTransformAttributeMethod(string $key): string
    {
        return 'transform'.Str::ucfirst($key).'Attribute';
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasTransformAttributeMethod(string $key): bool
    {
        return method_exists($this, $this->getTransformAttributeMethod($key));
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
                    $this->hasTransformAttributeMethod($attribute) ?
                        $this->{$this->getTransformAttributeMethod($attribute)}($value) : $value;
            }
        }

        return $this->buildAttributesString($attributes);
    }

    /**
     * @return string
     */
    protected function getDataAttributesString(): string
    {
        return $this->buildAttributesString($this->dataAttributes, 'data');
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
     * @return string|bool
     */
    protected function getTransformedContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    protected function getTagPattern(): string
    {
        return '<%s%s%s>%s';
    }

    /**
     * @return array
     */
    protected function getTagPatternAttributes(): array
    {
        return [
            $this->tag,
            $this->getAttributesString(),
            $this->getDataAttributesString(),
            $this->getTransformedContent(),
        ];
    }

    /**
     * @return string
     */
    protected function getClosedTagPattern(): string
    {
        return '<%s%s%s>%s</%s>';
    }

    /**
     * @return array
     */
    protected function getClosedTagPatternAttributes(): array
    {
        return [
            $this->tag,
            $this->getAttributesString(),
            $this->getDataAttributesString(),
            $this->getTransformedContent(),
            $this->tag,
        ];
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

    /**
     * @return string
     */
    public function close()
    {
        return $this->closeTag ? "</{$this->tag}>" : '';
    }

    /**
     * @param string|bool $class
     * @return Element
     */
    public function jsClass($class): Element
    {
        $this->attributeClass = $class === false ? false : "js-{$class}";

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        if ($this->hasAttribute($key)) {
            return true;
        } elseif ($this->isDataAttribute($key)) {
            return $this->hasDataAttribute($key);
        }

        return false;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function __set(string $key, $value): void
    {
        if ($this->hasAttribute($key)) {
            // Perform attribute validation, if needed
            if ($this->hasAttributeValidationMethod($key)) {
                $this->{$this->getAttributeValidationMethod($key)}($value);
            }

            $this->{$this->getInternalAttributeKey($key)} = $value;

            return;
        // Because data attributes are set on the fly we don't have to check for their existence
        } elseif ($this->isDataAttribute($key)) {
            $this->validateDataAttributeValue($value);

            $this->dataAttributes[$this->getInternalDataAttributeKey($key)] = $value;

            return;
        }

        throw new InvalidArgumentException("Undefined property {$key}.");
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        if ($this->hasAttribute($key)) {
            return $this->{$this->getInternalAttributeKey($key)};
        } elseif ($this->isDataAttribute($key) && $this->hasDataAttribute($key)) {
            return $this->dataAttributes[$this->getInternalDataAttributeKey($key)];
        }

        throw new InvalidArgumentException("Undefined property {$key}.");
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return Element
     */
    public function __call(string $name, array $arguments): Element
    {
        if ($this->hasAttribute($name)) {
            // Perform attribute validation, if needed
            if ($this->hasAttributeValidationMethod($name)) {
                $this->{$this->getAttributeValidationMethod($name)}($arguments[0] ?? false);
            }

            $this->{$this->getInternalAttributeKey($name)} = $arguments[0] ?? false;

            return $this;
        // Because data attributes are set on the fly we don't have to check for their existence
        } elseif ($this->isDataAttribute($name)) {
            if (count($arguments) == 0) {
                return $this;
            }

            $this->validateDataAttributeValue($arguments[0]);

            $this->dataAttributes[$this->getInternalDataAttributeKey($name)] = $arguments[0];

            return $this;
        }

        throw new BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $name));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        try {
            if (! $this->tag) {
                throw new RuntimeException('A valid tag must be specified when creating the element.');
            }

            return vsprintf(
                $this->closeTag ? $this->getClosedTagPattern() : $this->getTagPattern(),
                $this->closeTag ? $this->getClosedTagPatternAttributes() : $this->getTagPatternAttributes()
            );
        } catch (Exception $ex) {
            return '';
        }
    }
}
