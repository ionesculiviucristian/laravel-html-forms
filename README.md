###### This is a WIP package. Do not use in production.

# Laravel HTML Form

[![StyleCI Shield](https://github.styleci.io/repos/180137181/shield?branch=master)](https://github.styleci.io/repos/178866307/shield?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ionesculiviucristian/laravel-html-forms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ionesculiviucristian/laravel-html-forms/badges/quality-score.png?b=master)
[![Build Status](https://travis-ci.org/ionesculiviucristian/laravel-html-forms.png)](https://travis-ci.org/ionesculiviucristian/laravel-html-forms)
[![Latest Stable Version](https://poser.pugx.org/ionesculiviucristian/laravel-html-forms/v/stable)](https://packagist.org/packages/ionesculiviucristian/laravel-html-forms)
[![Total Downloads](https://poser.pugx.org/ionesculiviucristian/laravel-html-forms/downloads)](https://packagist.org/packages/ionesculiviucristian/laravel-html-forms)
[![License](https://poser.pugx.org/ionesculiviucristian/laravel-html-forms/license)](https://packagist.org/packages/ionesculiviucristian/laravel-html-forms)

This package provides a simple way to generate HTML elements programmatically.

## Installation

You can install the package via composer:

```bash
composer require ionesculiviucristian/laravel-html-forms
```

## Usage

``` php
$button = new \ionesculiviucristian\LaravelHtmlForms\Button;

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
