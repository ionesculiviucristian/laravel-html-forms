<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Form;

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
    }
}
