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
            ->csrf(false)
            ->method('post')
            ->enctype('multipart/form-data');

        $this->assertEquals('<form method="post" enctype="multipart/form-data">', (string) $form);

        $form2 = new class extends Form {
        };

        $form2->method('put');

        $this->assertEquals('<form method="post"><input type="hidden" name="_method" value="put">', (string) $form2);

        $form3 = new class extends Form {
        };

        $form3->method('delete')->csrf(true);

        $this->assertEquals('<form method="post"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="">', (string) $form3);
    }

    /** @test */
    public function it_renders_the_properties_correctly(): void
    {
        $form = new class extends Form {
        };

        $form->csrf(true);

        $this->assertEquals(true, $form->getCsrf());
    }

    /** @test */
    public function ir_renders_the_form_correctly_based_on_the_action_type()
    {
        $form = new class extends Form {
        };

        $form->get('http://test.com');

        $this->assertEquals('<form action="http://test.com" method="get"><input type="hidden" name="_token" value="">', (string) $form);

        $form2 = new class extends Form {
        };

        $form2->post('http://test2.com');

        $this->assertEquals('<form action="http://test2.com" method="post"><input type="hidden" name="_token" value="">', (string) $form2);

        $form3 = new class extends Form {
        };

        $form3->put('http://test3.com');

        $this->assertEquals('<form action="http://test3.com" method="post"><input type="hidden" name="_method" value="put"><input type="hidden" name="_token" value="">', (string) $form3);

        $form4 = new class extends Form {
        };

        $form4->delete('http://test4.com');

        $this->assertEquals('<form action="http://test4.com" method="post"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="">', (string) $form4);
    }

    /** @test */
    public function it_validates_boolean_values_assigned_to_method_attribute()
    {
        $form = new class extends Form {
        };

        $form->method = false;

        $this->addToAssertionCount(1);
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
}
