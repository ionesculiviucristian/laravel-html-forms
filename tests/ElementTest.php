<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use BadMethodCallException;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasCheckedAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\HasMultipleAttribute;
use ionesculiviucristian\LaravelHtmlForms\Traits\InteractsWithForms;
use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Element;

class ElementTest extends TestCase
{
    /** @test */
    public function it_sets_the_attributes_correctly(): void
    {
        $element = new class extends Element {
            protected $attributeTest1 = false;
            protected $attributeTest2 = false;
        };

        foreach (['test1', 'test2'] as $attribute) {
            // Through setter
            $element->{$attribute} = ($value = Str::random(5));

            $this->assertEquals($value, $element->{$attribute});

            // Through call
            $element->{$attribute}($value = Str::random(5));

            $this->assertEquals($value, $element->{$attribute});
        }
    }

    /** @test */
    public function it_sets_the_data_attributes_correctly(): void
    {
        $element = new class extends Element {
            protected $dataAttributes = [
                'test1' => false,
                'test2' => false,
            ];
        };

        foreach (['test1', 'test2'] as $dataAttribute) {
            $dataAttribute = 'data'.ucfirst($dataAttribute);

            // Through setter
            $element->{$dataAttribute} = ($value = Str::random(5));

            $this->assertEquals($value, $element->{$dataAttribute});

            // Through call
            $element->{$dataAttribute}($value = Str::random(5));

            $this->assertEquals($value, $element->{$dataAttribute});

            $element->{$dataAttribute}();

            $this->assertEquals($value, $element->{$dataAttribute});
        }
    }

    /** @test */
    public function it_sets_the_properties_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setTag('test')->setCloseTag(true)->setContent('content test');

        $this->assertEquals('test', $element->getTag());

        $this->assertEquals(true, $element->getCloseTag());

        $this->assertEquals('content test', $element->getContent());
    }

    /** @test */
    public function it_sets_the_non_value_attributes_correctly()
    {
        $attributes = [
            'checked',
            'multiple',
            'required',
            'disabled',
            'readonly',
        ];

        foreach ($attributes as $attribute) {
            $element = new class extends Element {
                use InteractsWithForms;
                use HasCheckedAttribute;
                use HasMultipleAttribute;

                protected $tag = 'input';

                protected $closeTag = false;
            };

            $element->{$attribute}(true);

            $this->assertEquals("<input {$attribute}>", (string) $element);
        }
    }

    /** @test */
    public function it_can_check_for_attributes_existence_correctly(): void
    {
        $element = new class extends Element {
            protected $attributeTest1 = false;
            protected $attributeTest2 = false;

            protected $dataAttributes = [
                'test1' => false,
                'test2' => false,
            ];
        };

        foreach (['test1', 'test2'] as $attribute) {
            $this->assertTrue(isset($element->{$attribute}));
        }

        foreach (['test1', 'test2'] as $dataAttribute) {
            $this->assertTrue(isset($element->{'data'.ucfirst($dataAttribute)}));
        }

        $this->assertFalse(isset($element->test));
    }

    /** @test */
    public function it_closes_the_tag_correctly()
    {
        $element = new class extends Element {
            protected $tag = 'test';
        };

        $this->assertEquals('</test>', $element->close());

        $element->setCloseTag(false);

        $this->assertEquals('', $element->close());
    }

    /** @test */
    public function it_throws_an_exception_when_setting_undefined_attributes(): void
    {
        $element = new class extends Element {
        };

        $this->expectException(InvalidArgumentException::class);

        $element->test = 'test';
    }

    /** @test */
    public function it_throws_an_exception_when_getting_undefined_attributes(): void
    {
        $element = new class extends Element {
        };

        $this->expectException(InvalidArgumentException::class);

        $element->test;
    }

    /** @test */
    public function it_throws_an_exception_when_getting_undefined_data_attributes(): void
    {
        $element = new class extends Element {
        };

        $this->expectException(InvalidArgumentException::class);

        $element->dataTest;
    }

    /** @test */
    public function it_throws_an_exception_when_calling_undefined_methods(): void
    {
        $element = new class extends Element {
        };

        $this->expectException(BadMethodCallException::class);

        $element->test();
    }

    /** @test */
    public function it_throws_an_exception_when_setting_non_scalar_values_on_data_attributes_through_setter(): void
    {
        $element = new class extends Element {
            protected $dataAttributes = [
                'key1' => false
            ];
        };

        $this->expectException(InvalidArgumentException::class);

        $element->dataKey1 = ['test'];
    }

    /** @test */
    public function it_throws_an_exception_when_setting_non_scalar_values_on_data_attributes_through_call(): void
    {
        $element = new class extends Element {
            protected $dataAttributes = [
                'key1' => false
            ];
        };

        $this->expectException(InvalidArgumentException::class);

        $element->dataKey1(['test']);
    }

    /** @test */
    public function it_validates_boolean_values_assigned_to_data_attribute()
    {
        $element = new class extends Element {
        };

        $element->dataTest = false;

        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_returns_an_empty_string_when_an_exception_is_raised_while_rendering_the_element(): void
    {
        $element = new class extends Element {
        };

        $this->assertEquals('', (string) $element);
    }

    /** @test */
    public function it_renders_the_tag_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setTag('test');

        $element->setCloseTag(false);

        $this->assertEquals('<test>', (string) $element);
    }

    /** @test */
    public function it_renders_the_closed_tag_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setTag('test');

        $this->assertEquals('<test></test>', (string) $element);
    }

    /** @test */
    public function it_renders_the_attributes_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setTag('test');

        $this->assertEquals(
            '<test title="my title" id="my-id" class="my-class" style="width:100px;height:50px">my content</test>',
            (string) $element
                ->title('my title')
                ->id('my-id')
                ->class('my-class')
                ->style('width:100px;height:50px')
                ->setContent('my content')
        );
    }

    /** @test */
    public function it_renders_the_data_attributes_correctly(): void
    {
        $element = new class extends Element {
            protected $dataAttributes = [
                'test1' => false,
                'test2' => false,
            ];
        };
        $element->setTag('test');

        $this->assertEquals(
            '<test data-test1="test1-value" data-test2="test2-value"></test>',
            (string) $element
                ->dataTest1('test1-value')
                ->dataTest2('test2-value')
        );
    }
}
