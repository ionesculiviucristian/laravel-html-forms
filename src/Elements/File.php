<?php

namespace ionesculiviucristian\LaravelHtmlForms\Elements;

use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\IsClosedInputTag;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasTypeAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasMultipleAttribute;

/**
 * @property string|bool $accept
 *
 * @method File accept(string|bool $value)
 */
class File extends Element
{
    use IsClosedInputTag;
    use HasTypeAttribute;
    use InteractsWithForms;
    use HasMultipleAttribute;

    /**
     * @var string|bool
     */
    protected $attributeAccept = false;

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->setAsClosedInputTag();

        $this->attributeType = 'file';
    }

    /**
     * @return File
     */
    public function acceptImages()
    {
        $this->attributeAccept = 'image/*';

        return $this;
    }

    /**
     * @return File
     */
    public function acceptDocuments()
    {
        $this->attributeAccept = '.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document';

        return $this;
    }
}
