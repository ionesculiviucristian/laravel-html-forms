<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use BadMethodCallException;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForm\Element;

class ElementTest extends TestCase
{
    /** @test */
    public function it_sets_the_custom_attributes_correctly(): void
    {
        $element = new class extends Element {
        };

        // Method assignment
        $element->setCustomAttributes([
            'customAttribute1' => 'custom-attribute1-value',
            'customAttribute2' => 'custom-attribute2-value',
        ]);

        $customAttributes = $element->getCustomAttributes();

        foreach ($customAttributes as $customAttribute => $startValue) {
            $element->{$customAttribute}($value = Str::random(5));

            $this->assertEquals($value, $element->{$customAttribute});
        }

        // Direct assignment
        $element->customAttribute1 = 'new-custom-attribute1-value';
        $element->customAttribute2 = 'new-custom-attribute2-value';

        $customAttributes = $element->getCustomAttributes();

        foreach ($customAttributes as $customAttribute => $startValue) {
            $element->{$customAttribute}($value = Str::random(5));

            $this->assertEquals($value, $element->{$customAttribute});
        }
    }

    /** @test */
    public function it_sets_the_attributes_correctly(): void
    {
        $element = new class extends Element {
        };

        // Method assignment
        $element->setAttributes([
            'attribute1' => 'attribute1-value',
            'attribute2' => 'attribute2-value',
        ]);

        $attributes = $element->getAttributes();

        foreach ($attributes as $attribute => $startValue) {
            $element->{$attribute}($value = Str::random(5));

            $this->assertEquals($value, $element->{$attribute});
        }

        // Direct assignment
        $element->attribute1 = 'new-attribute1-value';
        $element->attribute2 = 'new-attribute2-value';

        $attributes = $element->getAttributes();

        foreach ($attributes as $attribute => $startValue) {
            $element->{$attribute}($value = Str::random(5));

            $this->assertEquals($value, $element->{$attribute});
        }
    }

    /** @test */
    public function it_sets_the_data_attributes_correctly(): void
    {
        $element = new class extends Element {
        };

        // Method assignment
        $element->setDataAttributes([
            'key1' => 'data-value1',
            'key2' => 'data-value2',
            'key3' => 'data-value3',
        ]);

        $dataAttributes = $element->getDataAttributes();

        foreach ($dataAttributes as $dataAttribute => $value) {
            $this->assertEquals($value, $element->{'data'.ucfirst($dataAttribute)});
        }

        // Direct assignment
        $element->dataKey1 = 'new-data-value1';
        $element->dataKey2 = 'new-data-value2';
        $element->dataKey3 = 'new-data-value3';

        $dataAttributes = $element->getDataAttributes();

        foreach ($dataAttributes as $dataAttribute => $value) {
            $this->assertEquals($value, $element->{'data'.ucfirst($dataAttribute)});
        }
    }

    /** @test */
    public function it_sets_the_properties_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setTag('test')->content('content test');

        $this->assertEquals('test', $element->getTag());

        $this->assertEquals('content test', $element->getContent());
    }

    /** @test */
    public function it_can_check_for_attributes_existence_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setAttributes([
            'attribute1' => 'attribute1-value',
            'attribute2' => 'attribute2-value',
        ]);

        $element->setCustomAttributes([
            'customAttribute1' => 'custom-attribute1-value',
            'customAttribute2' => 'custom-attribute2-value',
        ]);

        $element->setDataAttributes([
            'key1' => 'data-value1',
            'key2' => 'data-value2',
            'key3' => 'data-value3',
        ]);

        $attributes = $element->getAttributes();

        foreach ($attributes as $attribute => $startValue) {
            $this->assertTrue(isset($element->{$attribute}));
        }

        $customAttributes = $element->getCustomAttributes();

        foreach ($customAttributes as $customAttribute => $startValue) {
            $this->assertTrue(isset($element->{$customAttribute}));
        }

        $dataAttributes = $element->getDataAttributes();

        foreach ($dataAttributes as $dataAttribute => $value) {
            $this->assertTrue(isset($element->{'data'.ucfirst($dataAttribute)}));
        }

        $this->assertFalse(isset($element->test));
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
    public function it_throws_an_exception_when_calling_undefined_methods(): void
    {
        $element = new class extends Element {
        };

        $this->expectException(BadMethodCallException::class);

        $element->test();
    }

    /** @test */
    public function it_throws_an_exception_when_setting_non_scalar_values_on_data_attributes(): void
    {
        $element1 = new class extends Element {
        };

        $element1->data(['key1' => 'value1']);

        $this->addToAssertionCount(1);

        $element2 = new class extends Element {
        };

        $this->expectException(InvalidArgumentException::class);

        $element2->data(['key2' => []]);
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
    public function it_renders_the_custom_attributes_correctly(): void
    {
        $element = new class extends Element {
        };

        $element->setTag('test');

        $element->setCustomAttributes([
            'custom1' => false,
            'custom2' => false,
        ]);

        $this->assertEquals(
            '<test custom1="custom1-value" custom2="custom2-value"></test>',
            (string) $element
                ->custom1('custom1-value')
                ->custom2('custom2-value')
        );
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
                ->content('my content')
        );
    }

    /** @test */
    public function it_renders_the_data_attributes_correctly(): void
    {
        $element = new class extends Element {
        };
        $element->setTag('test');

        $this->assertEquals(
            '<test data-test1="test1-value" data-test2="test2-value"></test>',
            (string) $element
                ->data([
                    'test1' => 'test1-value',
                    'test2' => 'test2-value',
                ])
        );
    }
}
