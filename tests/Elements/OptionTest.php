<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Elements;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Option;

class OptionTest extends TestCase
{
    /** @test */
    public function it_renders_the_option_correctly(): void
    {
        $option = new class extends Option {
        };

        $option
            ->value('value1')
            ->setContent('test1');

        $this->assertEquals('<option value="value1">test1</option>', (string) $option);
    }
}
