<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\File;

class FileTest extends TestCase
{
    /** @test */
    public function it_renders_the_file_correctly(): void
    {
        $file = new class extends File {
        };

        $file->accept('application/pdf');

        $this->assertEquals('<input accept="application/pdf" type="file">', (string) $file);
    }
}
