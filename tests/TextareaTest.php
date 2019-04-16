<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Textarea;

class TextareaTest extends TestCase
{
    /** @test */
    public function it_renders_the_textarea_correctly(): void
    {
        $textarea = new class extends Textarea {
        };

        $this->assertEquals('<textarea></textarea>', (string) $textarea);
    }
}
