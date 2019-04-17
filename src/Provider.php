<?php

namespace ionesculiviucristian\LaravelHtmlForms;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function register()
    {
        $facades = $this->getFacades();

        $loader = AliasLoader::getInstance();

        foreach ($facades as $facade => $name) {
            $this->app->bind($facade, function() use ($name) {
                $class = "ionesculiviucristian\LaravelHtmlForms\Elements\\{$name}";

                return new $class;
            });

            $loader->alias($name, "ionesculiviucristian\LaravelHtmlForms\Facades\\{$name}");
        }
    }

    /**
     * @return array
     */
    protected function getFacades()
    {
        $facades = [];

        $files = File::files(__DIR__.'/Elements');

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $name = str_replace('.php', '', $file->getFilename());

            $facades[Str::slug($name, '_')] = $name;
        }

        return $facades;
    }
}
