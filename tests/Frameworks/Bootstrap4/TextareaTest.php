<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Textarea;

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

        $this->assertEquals('<textarea class="form-control">test1</textarea>', (string) $textarea);
    }
}
