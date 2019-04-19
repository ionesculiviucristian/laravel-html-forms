<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Textarea;

class TextareaTest extends TestCase
{
    /** @test */
    public function it_renders_the_textarea_correctly(): void
    {
        $textarea = new class extends Textarea {
        };

        $textarea
            ->value('value1')
            ->setContent('test1');

        $this->assertEquals('<textarea>test1</textarea>', (string) $textarea);
    }
}
