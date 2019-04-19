<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Radio;

class RadioTest extends TestCase
{
    /** @test */
    public function it_renders_the_radio_correctly(): void
    {
        $radio = new class extends Radio {
        };

        $this->assertEquals('<input type="radio">', (string) $radio);
    }
}
