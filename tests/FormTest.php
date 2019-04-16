<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Elements\Form;

class FormTest extends TestCase
{
    /** @test */
    public function it_renders_the_form_correctly(): void
    {
        $form = new class extends Form {
        };

        $form
            ->method('post')
            ->enctype('multipart/form-data');

        $this->assertEquals('<form method="post" enctype="multipart/form-data">', (string) $form);
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_enctype_attribute_value_through_setter()
    {
        $form = new class extends Form {
        };

        $this->expectException(InvalidArgumentException::class);

        $form->enctype = 'test';
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_enctype_attribute_value_through_call()
    {
        $form = new class extends Form {
        };

        $this->expectException(InvalidArgumentException::class);

        $form->enctype('test');
    }

    /** @test */
    public function it_validates_boolean_values_assigned_to_enctype_attribute()
    {
        $form = new class extends Form {
        };

        $form->enctype = false;

        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_method_attribute_value_through_setter()
    {
        $form = new class extends Form {
        };

        $this->expectException(InvalidArgumentException::class);

        $form->method = 'test';
    }

    /** @test */
    public function it_throws_an_exception_when_setting_an_incorrect_method_attribute_value_through_call()
    {
        $form = new class extends Form {
        };

        $this->expectException(InvalidArgumentException::class);

        $form->method('test');
    }

    /** @test */
    public function it_validates_boolean_values_assigned_to_method_attribute()
    {
        $form = new class extends Form {
        };

        $form->method = false;

        $this->addToAssertionCount(1);
    }
}
