<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Option;

class OptionTest extends TestCase
{
    /** @test */
    public function it_renders_the_option_correctly(): void
    {
        $option = new class extends Option {
        };

        $option
            ->selected(false)
            ->value('value1')
            ->setContent('test1');

        $this->assertEquals('<option value="value1">test1</option>', (string) $option);
    }
}
