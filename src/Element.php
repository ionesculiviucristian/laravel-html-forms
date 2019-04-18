<?php

namespace ionesculiviucristian\LaravelHtmlForms;

use Exception;
use RuntimeException;
use BadMethodCallException;
use InvalidArgumentException;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasAttributes;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasDataAttributes;

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
    use HasAttributes;
    use HasDataAttributes;

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
     * @var array|bool
     */
    protected $attributeClass = false;

    /**
     * @var array|bool
     */
    protected $attributeStyle = false;

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
     * @param string|bool $class
     * @return Element
     */
    public function jsClass($class): Element
    {
        $this->attributeClass = $this->transformInternalClassAttribute($class === false ? false : "js-{$class}");

        return $this;
    }

    /**
     * @param array $data
     * @return Element
     */
    public function data(array $data)
    {
        foreach ($data as $key => $value) {
            $this->dataAttributes[$key] = $value;
        }

        return $this;
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
     * @return string
     */
    public function close()
    {
        return $this->closeTag ? "</{$this->tag}>" : '';
    }

    /**
     * @return string|bool
     */
    protected function getTransformedContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $value
     * @return array|bool
     */
    protected function transformInternalClassAttribute($value)
    {
        return $this->transformInternalAttribute('attributeClass', $value);
    }

    /**
     * @return string|bool
     */
    protected function transformOutputClassAttribute()
    {
        return $this->transformOutputAttribute('attributeClass');
    }

    /**
     * @param mixed $value
     * @return array|bool
     */
    protected function transformInternalStyleAttribute($value)
    {
        return $this->transformInternalAttribute('attributeStyle', $value);
    }

    /**
     * @return string|bool
     */
    protected function transformOutputStyleAttribute()
    {
        return $this->transformOutputAttribute('attributeStyle', ';');
    }

    /**
     * @return string
     */
    protected function getDataAttributesString(): string
    {
        return $this->buildAttributesString($this->dataAttributes, 'data');
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

            $this->{$this->getInternalAttributeKey($key)} = $this->hasTransformInternalAttributeMethod($key) ?
                $this->{$this->getTransformInternalAttributeMethod($key)}($value) : $value;

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
            $this->{$name} = $arguments[0] ?? false;

            return $this;
        // Because data attributes are set on the fly we don't have to check for their existence
        } elseif ($this->isDataAttribute($name)) {
            if (count($arguments) == 0) {
                return $this;
            }

            $this->{$name} = $arguments[0];

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
