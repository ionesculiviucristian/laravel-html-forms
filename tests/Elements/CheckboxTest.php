<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Elements;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Checkbox;

class CheckboxTest extends TestCase
{
    /** @test */
    public function it_renders_the_checkbox_correctly(): void
    {
        $checkbox = new class extends Checkbox {
        };

        $this->assertEquals('<input type="checkbox">', (string) $checkbox);
    }
}
