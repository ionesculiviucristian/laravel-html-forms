<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Radio;

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
