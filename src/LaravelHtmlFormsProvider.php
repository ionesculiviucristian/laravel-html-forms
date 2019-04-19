<?php

namespace ionesculiviucristian\LaravelHtmlForms;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

class LaravelHtmlFormsProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/laravel_html_forms.php';

        $this->mergeConfigFrom($configPath, 'laravel-html-forms');

        $framework = config('laravel-html-forms.framework');

        $facades = $this->getFacades($framework);

        $loader = AliasLoader::getInstance();

        foreach ($facades as $facade => $name) {
            $this->app->bind($facade, function () use ($name, $framework) {
                $class = "ionesculiviucristian\LaravelHtmlForms\Frameworks\\{$framework}\\{$name}";

                return new $class;
            });

            $loader->alias($name, "ionesculiviucristian\LaravelHtmlForms\Facades\\{$name}");
        }
    }

    /**
     * @param string $framework
     * @return array
     */
    protected function getFacades(string $framework): array
    {
        $facades = [];

        $files = File::files(__DIR__."/Frameworks/{$framework}");

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $name = str_replace('.php', '', $file->getFilename());

            $facades[Str::slug($name, '_')] = $name;
        }

        return $facades;
    }
}
