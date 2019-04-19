<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Application;
use Symfony\Component\Finder\SplFileInfo;

class LaravelHtmlFormsProviderTest extends TestCase
{
    /** @test */
    public function it_registers_the_facades_correctly(): void
    {
        $config = require (__DIR__.'/../config/laravel_html_forms.php');

        $framework = Arr::get($config, 'framework');

        $facades = $this->getFacades($framework);

        foreach ($facades as $facade => $name) {
            $this->assertInstanceOf("ionesculiviucristian\LaravelHtmlForms\Frameworks\\{$framework}\\{$name}", $name::id('test'));
        }
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return ['ionesculiviucristian\LaravelHtmlForms\LaravelHtmlFormsProvider'];
    }

    /**
     * @param string $framework
     * @return array
     */
    protected function getFacades(string $framework): array
    {
        $facades = [];

        $files = File::files(__DIR__."/../src/Frameworks/{$framework}");

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $name = str_replace('.php', '', $file->getFilename());

            $facades[Str::slug($name, '_')] = $name;
        }

        return $facades;
    }
}
