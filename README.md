# Laravel HTML Form

This package provides a simple way to generate HTML elements programmatically.

## Installation

You can install the package via composer:

```bash
composer require ionesculiviucristian/laravel-html-form
```

## Usage

``` php
$button = new \ionesculiviucristian\LaravelHtmlForm\Button;

$button
    ->title('my title')
    ->id('my-id')
    ->class('my-class')
    ->style('width:100px;height:50px')
    ->content('my content');

echo $button;
```

outputs:

```
<button type="button" value="Button" title="my title" id="my-id" class="my-class" style="width:100px;height:50px">my content</test>
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Ionescu Liviu Cristian](https://github.com/ionesculiviucristian)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
