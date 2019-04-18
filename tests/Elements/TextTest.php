<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Elements;

use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Text;

class TextTest extends TestCase
{
    /** @test */
    public function it_renders_the_text_correctly(): void
    {
        $text = new class extends Text {
        };

        $text
            ->autofocus(true)
            ->autocomplete('off');

        $this->assertEquals('<input type="text" autocomplete="off" autofocus>', (string) $text);
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_autocomplete_attribute_value_through_setter()
    {
        $text = new class extends Text {
        };

        $this->expectException(InvalidArgumentException::class);

        $text->autocomplete = 'test';
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_autocomplete_attribute_value_through_call()
    {
        $text = new class extends Text {
        };

        $this->expectException(InvalidArgumentException::class);

        $text->autocomplete('test');
    }

    /** @test */
    public function it_validates_boolean_values_assigned_to_autocomplete_attribute()
    {
        $text = new class extends Text {
        };

        $text->autocomplete = false;

        $this->addToAssertionCount(1);
    }
}
