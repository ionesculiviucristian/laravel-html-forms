<?php

namespace ionesculiviucristian\LaravelHtmlForms\Frameworks\Base;

use BadMethodCallException;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ionesculiviucristian\LaravelHtmlForms\Element;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasTypeAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\IsClosedInputTag;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasMultipleAttribute;

/**
 * @property string|bool $accept
 *
 * @method File acceptImageFiles(string $value)
 * @method File acceptDocumentFiles(string $value)
 * @method File acceptSpreadsheetFiles(string $value)
 * @method File acceptPresentationFiles(string $value)
 * @method File acceptPdfFiles(string $value)
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
     * @var array
     */
    protected $acceptedFileMimesTypes = [
        'image' => [
            'image/jpeg',
            'image/png',
            'image/bmp',
            'image/gif',
            'image/bmp',
        ],
        'document' => [
            '.application/msword',
            '.application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ],
        'spreadsheet' => [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
        'presentation' => [
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ],
        'pdf' => [
            'application/pdf'
        ],
    ];

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->setAsClosedInputTag();

        $this->attributeType = 'file';

        $this->disabledAttributes = ['autocomplete'];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return File
     */
    public function __call(string $name, array $arguments): Element
    {
        if (Str::startsWith($name, 'accept') && Str::endsWith($name, 'Files')) {
            $type = Str::lower(Str::substr($name, 6, -5));
            $this->attributeAccept = $this->mergeMimeTypes($type);

            return $this;
        }

        throw new BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $name));
    }

    /**
     * @param string $type
     * @return string
     */
    protected function mergeMimeTypes(string $type): string
    {
        if (! array_key_exists($type, $this->acceptedFileMimesTypes)) {
            throw new InvalidArgumentException("You must define the {$type} mime type before using it.");
        }

        return implode(',', $this->acceptedFileMimesTypes[$type]);
    }
}
