<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Application;
use Symfony\Component\Finder\SplFileInfo;

class ProviderTest extends TestCase
{
    /** @test */
    public function it_registers_the_facades_correctly(): void
    {
        $facades = $this->getFacades();

        foreach ($facades as $facade => $name) {
            $this->assertInstanceOf("ionesculiviucristian\LaravelHtmlForms\Elements\\{$name}", $name::id('test'));
        }
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['ionesculiviucristian\LaravelHtmlForms\Provider'];
    }

    /**
     * @return array
     */
    protected function getFacades()
    {
        $facades = [];

        $files = File::files(__DIR__.'/../src/Elements');

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $name = str_replace('.php', '', $file->getFilename());

            $facades[Str::slug($name, '_')] = $name;
        }

        return $facades;
    }
}
