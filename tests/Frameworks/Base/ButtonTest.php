<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Button;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_the_button_correctly(): void
    {
        $button = new class extends Button {
        };

        $button->type('submit');

        $this->assertEquals('<input type="submit">', (string) $button);

        $button2 = new class extends Button {
        };

        $button2->submit();

        $this->assertEquals('<input type="submit">', (string) $button2);

        $button3 = new class extends Button {
        };

        $button3->reset();

        $this->assertEquals('<input type="reset">', (string) $button3);

        $button4 = new class extends Button {
        };

        $button4->button();

        $this->assertEquals('<input type="button">', (string) $button4);
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
