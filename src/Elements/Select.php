<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasMultipleAttribute;

class Select extends Element
{
    use InteractsWithForms;
    use HasMultipleAttribute;

    /**
     * @var string
     */
    protected $tag = 'select';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $selectedOptions = [];

    /**
     * @var array
     */
    protected $disabledOptions = [];

    /**
     * @param array $options
     * @return Select
     */
    public function options(array $options): Select
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param mixed $selected
     * @return Select
     */
    public function selected($selected): Select
    {
        $this->selectedOptions = (array) $selected;

        return $this;
    }

    /**
     * @return array
     */
    public function getSelected(): array
    {
        return $this->selectedOptions;
    }

    /**
     * @param mixed $disabled
     * @return Select
     */
    public function disabled($disabled): Select
    {
        $this->disabledOptions = (array) $disabled;

        return $this;
    }

    /**
     * @return array
     */
    public function getDisabled(): array
    {
        return $this->disabledOptions;
    }

    /**
     * @return string|bool
     */
    protected function getTransformedContent()
    {
        $optionsString = '';

        foreach ($this->options as $value => $text) {
            $optionsString .= "<option value=\"{$value}\"";

            if (in_array($value, $this->selectedOptions)) {
                $optionsString .= ' selected';
            }

            if (in_array($value, $this->disabledOptions)) {
                $optionsString .= ' disabled';
            }

            $optionsString .= ">{$text}</option>";
        }

        return $optionsString;
    }
}
