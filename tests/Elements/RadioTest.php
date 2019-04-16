<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Elements;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Radio;

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
