<?php

namespace ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4;

use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Button as BaseButton;

class Button extends BaseButton
{
    /**
     * @var array|bool
     */
    protected $attributeClass = ['btn'];

    /**
     * @var array
     */
    protected $sizes = ['btn-lg', 'btn-sm'];

    /**
     * @var array
     */
    protected $variants = [
        'btn-primary',
        'btn-outline-primary',
        'btn-secondary',
        'btn-outline-secondary',
        'btn-success',
        'btn-outline-success',
        'btn-danger',
        'btn-outline-danger',
        'btn-warning',
        'btn-outline-warning',
        'btn-info',
        'btn-outline-info',
        'btn-link',
    ];

    /**
     * @param bool $outline
     * @return Button
     */
    public function primary(bool $outline = false): Button
    {
        return $this->toggleVariant('primary', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function secondary(bool $outline = false): Button
    {
        return $this->toggleVariant('secondary', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function success(bool $outline = false): Button
    {
        return $this->toggleVariant('success', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function danger(bool $outline = false): Button
    {
        return $this->toggleVariant('danger', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function warning(bool $outline = false): Button
    {
        return $this->toggleVariant('warning', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function info(bool $outline = false): Button
    {
        return $this->toggleVariant('info', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function light(bool $outline = false): Button
    {
        return $this->toggleVariant('light', $outline);
    }

    /**
     * @param bool $outline
     * @return Button
     */
    public function dark(bool $outline = false): Button
    {
        return $this->toggleVariant('dark', $outline);
    }

    /**
     * @return Button
     */
    public function link(): Button
    {
        $this->class = 'btn-link';

        return $this;
    }

    /**
     * @return Button
     */
    public function large(): Button
    {
        return $this->toggleSize('btn-lg');
    }

    /**
     * @return Button
     */
    public function small(): Button
    {
        return $this->toggleSize('btn-sm');
    }

    /**
     * @param bool $active
     * @return Button
     */
    public function active(bool $active = true): Button
    {
        return $this->toggleState('active', $active);
    }

    /**
     * @param bool $disabled
     * @return Button
     */
    public function disabled(bool $disabled = true): Button
    {
        $this->attributeDisabled = $disabled;

        return $this->toggleState('disabled', $disabled);
    }

    /**
     * @param string $variant
     * @param bool $outline
     * @return Button
     */
    protected function toggleVariant(string $variant, $outline = false): Button
    {
        $this->attributeClass = is_array($this->attributeClass) ? $this->attributeClass : [];

        foreach ($this->attributeClass as $key => $class) {
            if (in_array($class, $this->variants)) {
                unset($this->attributeClass[$key]);
            }
        }

        $this->class = 'btn-'.($outline ? 'outline-' : '').$variant;

        return $this;
    }

    /**
     * @param string $size
     * @return Button
     */
    protected function toggleSize(string $size): button
    {
        $this->attributeClass = is_array($this->attributeClass) ? $this->attributeClass : [];

        foreach ($this->attributeClass as $key => $class) {
            if (in_array($class, $this->sizes)) {
                unset($this->attributeClass[$key]);
            }
        }

        $this->class = $size;

        return $this;
    }

    /**
     * @param string $state
     * @param bool $on
     * @return Button
     */
    protected function toggleState(string $state, bool $on): button
    {
        $this->attributeClass = is_array($this->attributeClass) ? $this->attributeClass : [];

        foreach ($this->attributeClass as $key => $class) {
            if ($class == $state) {
                if (! $on) {
                    unset($this->attributeClass[$key]);
                }

                return $this;
            }
        }

        $this->class = $state;

        return $this;
    }
}
