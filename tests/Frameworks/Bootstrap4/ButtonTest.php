<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Bootstrap4;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Bootstrap4\Button;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_the_button_correctly(): void
    {
        $button = new class extends Button {
        };

        $this->assertEquals('<input class="btn" type="button">', (string) $button);

        $variants = [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'light',
            'dark',
            'link',
        ];

        foreach ($variants as $variant) {
            $button2 = new class extends Button {
            };

            $button2->{$variant}();

            $this->assertEquals('<input class="btn btn-'.$variant.'" type="button">', (string) $button2);
        }
    }
}
