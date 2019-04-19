<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Checkbox;

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
