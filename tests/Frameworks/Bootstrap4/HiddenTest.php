<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Hidden;

class HiddenTest extends TestCase
{
    /** @test */
    public function it_renders_the_hidden_correctly(): void
    {
        $hidden = new class extends Hidden {
        };

        $this->assertEquals('<input type="hidden">', (string) $hidden);
    }
}
