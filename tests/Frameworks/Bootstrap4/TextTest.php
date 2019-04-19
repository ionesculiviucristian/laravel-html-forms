<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Text;

class TextTest extends TestCase
{
    /** @test */
    public function it_renders_the_text_correctly(): void
    {
        $text = new class extends Text {
        };

        $text
            ->autofocus(true)
            ->autocomplete('off');

        $this->assertEquals('<input class="form-control" type="text" autocomplete="off" autofocus>', (string) $text);
    }
}
