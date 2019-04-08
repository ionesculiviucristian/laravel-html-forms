<?php

namespace ionesculiviucristian\LaravelHtmlForm;

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
 *
 * @method data(array $values): Element
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
     * @var array
     */
    protected $attributes = [
        'title' => false,
        'id'    => false,
        'class' => false,
        'style' => false,
    ];

    /**
     * @var array
     */
    protected $customAttributes = [];

    /**
     * @var array
     */
    protected $dataAttributes = [];

    /**
     * @var string
     */
    protected $content;

    /**
     * @param string $content
     * @return Element
     */
    public function content(string $content): Element
    {
        $this->content = $content;

        return $this;
    }

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
     * @param bool $closeTag
     * @return Element
     */
    public function setCloseTag(bool $closeTag): Element
    {
        $this->closeTag = $closeTag;

        return $this;
    }

    /**
     * @param array $attributes
     * @return Element
     */
    public function setAttributes(array $attributes): Element
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $attributes
     * @return Element
     */
    public function setCustomAttributes(array $attributes): Element
    {
        $this->customAttributes = $attributes;

        return $this;
    }

    /**
     * @param array $attributes
     * @return Element
     */
    public function setDataAttributes(array $attributes): Element
    {
        $this->dataAttributes = $attributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getCustomAttributes(): array
    {
        return $this->customAttributes;
    }

    /**
     * @return array
     */
    public function getDataAttributes(): array
    {
        return $this->dataAttributes;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
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
    protected function isDataAttribute(string $key): bool
    {
        return Str::startsWith($key, 'data');
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasAttribute(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
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
    protected function hasCustomAttribute(string $key): bool
    {
        return array_key_exists($key, $this->customAttributes);
    }

    /**
     * @return string
     */
    protected function getAttributesString(): string
    {
        $string = [];

        $attributes = array_filter($this->attributes, static function ($attribute) {
            return (bool) $attribute;
        });

        foreach ($attributes as $key => $value) {
            $string[] = "{$key}=\"{$value}\"";
        }

        return count($string) ? ' '.implode(' ', $string) : '';
    }

    /**
     * @return string
     */
    protected function getCustomAttributesString(): string
    {
        $string = [];

        $attributes = array_filter($this->customAttributes, static function ($attribute) {
            return (bool) $attribute;
        });

        foreach ($attributes as $key => $value) {
            $string[] = "{$key}=\"{$value}\"";
        }

        return count($string) ? ' '.implode(' ', $string) : '';
    }

    /**
     * @return string
     */
    protected function getDataAttributesString(): string
    {
        $string = [];

        $attributes = array_filter($this->dataAttributes, static function ($attribute) {
            return (bool) $attribute;
        });

        foreach ($attributes as $key => $value) {
            $string[] = "data-{$key}=\"{$value}\"";
        }

        return count($string) ? ' '.implode(' ', $string) : '';
    }

    /**
     * @return string
     */
    protected function getTagPattern(): string
    {
        return '<%s%s%s%s>';
    }

    /**
     * @return array
     */
    protected function getTagPatternAttributes(): array
    {
        return [
            $this->tag,
            $this->getCustomAttributesString(),
            $this->getAttributesString(),
            $this->getDataAttributesString(),
        ];
    }

    /**
     * @return string
     */
    protected function getClosedTagPattern(): string
    {
        return '<%s%s%s%s>%s</%s>';
    }

    /**
     * @return array
     */
    protected function getClosedTagPatternAttributes(): array
    {
        return [
            $this->tag,
            $this->getCustomAttributesString(),
            $this->getAttributesString(),
            $this->getDataAttributesString(),
            $this->content,
            $this->tag,
        ];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        if ($this->hasAttribute($key)) {
            return true;
        }

        if ($this->hasCustomAttribute($key)) {
            return true;
        }

        if ($this->isDataAttribute($key)) {
            return $this->hasDataAttribute($key);
        }

        return false;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return Element
     * @throws Exception
     */
    public function __set(string $key, $value)
    {
        if ($this->hasAttribute($key)) {
            $this->attributes[$key] = $value;

            return $this;
        }

        if ($this->hasCustomAttribute($key)) {
            $this->customAttributes[$key] = $value;

            return $this;
        }

        if ($this->isDataAttribute($key)) {
            $this->dataAttributes[$this->getInternalDataAttributeKey($key)] = $value;

            return $this;
        }

        throw new InvalidArgumentException("Undefined property {$key}.");
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function __get(string $key)
    {
        if ($this->hasAttribute($key)) {
            return $this->attributes[$key];
        }

        if ($this->hasCustomAttribute($key)) {
            return $this->customAttributes[$key];
        }

        if ($this->isDataAttribute($key)) {
            return $this->dataAttributes[$this->getInternalDataAttributeKey($key)];
        }

        throw new InvalidArgumentException("Undefined property {$key}.");
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return Element
     */
    public function __call(string $name, array $arguments)
    {
        if ($this->hasAttribute($name)) {
            $this->attributes[$name] = $arguments[0] ?? false;

            return $this;
        }

        if ($this->hasCustomAttribute($name)) {
            $this->customAttributes[$name] = $arguments[0] ?? false;

            return $this;
        }

        if ($this->isDataAttribute($name)) {
            $data = is_array($arguments[0]) ? $arguments[0] : [$arguments[0]];

            foreach ($data as $key => $value) {
                if (! is_scalar($value)) {
                    throw new InvalidArgumentException('Only scalar values can be passed to data attributes.');
                }

                $this->dataAttributes[$key] = $value;
            }

            return $this;
        }

        throw new BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $name));
    }

    /**
     * @return string
     */
    public function __toString()
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
