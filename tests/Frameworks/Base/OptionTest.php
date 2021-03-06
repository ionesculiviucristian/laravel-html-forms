<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Option;

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
