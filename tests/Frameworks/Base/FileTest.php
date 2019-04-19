<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\File;

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

    /** @test */
    public function it_sets_shorthand_accept_attributes()
    {
        $file = new class extends File {
        };

        $file->acceptImages();

        $this->assertEquals('image/*', $file->accept);

        $file->acceptDocuments();

        $this->assertEquals('.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document', $file->accept);
    }
}
