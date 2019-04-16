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
     * @var bool
     */
    protected $csrf = false;

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
     * @param bool $csrf
     * @return Form
     */
    public function csrf(bool $csrf): Form
    {
        $this->csrf = $csrf;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCsrf(): bool
    {
        return $this->csrf;
    }

    /**
     * @param string|bool $action
     * @param bool $csrf
     * @return Form
     */
    public function get($action = false, $csrf = true): Form
    {
        $this->attributeMethod = 'get';

        $this->attributeAction = $action;

        $this->csrf = $csrf;

        if ($csrf) {
            $this->content = '<input type="hidden" name="_token" value="'.csrf_token().'">';
        }

        return $this;
    }

    /**
     * @param string|bool $action
     * @param bool $csrf
     * @return Form
     */
    public function post($action = false, $csrf = true): Form
    {
        $this->attributeMethod = 'post';

        $this->attributeAction = $action;

        $this->csrf = $csrf;

        if ($csrf) {
            $this->content = '<input type="hidden" name="_token" value="'.csrf_token().'">';
        }

        return $this;
    }

    /**
     * @param string|bool $action
     * @param bool $csrf
     * @return Form
     */
    public function put($action = false, $csrf = true): Form
    {
        $this->attributeMethod = 'post';

        $this->attributeAction = $action;

        $this->csrf = $csrf;

        $this->content = '<input type="hidden" name="_method" value="put">';

        if ($csrf) {
            $this->content .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
        }

        return $this;
    }

    /**
     * @param string|bool $action
     * @param bool $csrf
     * @return Form
     */
    public function delete($action = false, $csrf = true): Form
    {
        $this->attributeMethod = 'post';

        $this->attributeAction = $action;

        $this->content = '<input type="hidden" name="_method" value="delete">';

        if ($csrf) {
            $this->content .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
        }

        return $this;
    }

    /**
     * @return string|bool
     */
    protected function getTransformedContent()
    {
        // This should happen when using get/post/put/delete methods or when set manually
        if ($this->content) {
            return $this->content;
        }

        $content = '';

        switch ($this->attributeMethod) {
            case 'put':
                $content .= '<input type="hidden" name="_method" value="put">';

                break;
            case 'delete':
                $content .= '<input type="hidden" name="_method" value="delete">';

                break;
        }

        if ($this->csrf) {
            $content .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
        }

        return $content;
    }

    /**
     * @param string $method
     * @return string
     */
    protected function transformMethodAttribute(string $method): string
    {
        if (in_array($method, ['put', 'delete'])) {
            return 'post';
        }

        return $method;
    }

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

        if (! in_array(Str::lower($value), ['get', 'post', 'put', 'delete'])) {
            throw new InvalidArgumentException("{$value} is not a valid type attribute.");
        }
    }
}
