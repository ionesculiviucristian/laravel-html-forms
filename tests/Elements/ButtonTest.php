<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Elements;

use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Button;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_the_button_correctly(): void
    {
        $button = new class extends Button {
        };

        $button->type('submit');

        $this->assertEquals('<input type="submit">', (string) $button);
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_type_attribute_value_through_setter()
    {
        $button = new class extends Button {
        };

        $button->type = false;

        $this->addToAssertionCount(1);

        $this->expectException(InvalidArgumentException::class);

        $button->type = 'test';
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_type_attribute_value_through_call()
    {
        $button = new class extends Button {
        };

        $button->type(false);

        $this->addToAssertionCount(1);

        $this->expectException(InvalidArgumentException::class);

        $button->type('test');
    }
}
