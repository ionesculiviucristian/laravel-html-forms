<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForm\Button;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_the_button_correctly(): void
    {
        $button = new Button;

        // Custom attributes
        $button
            ->type('submit')
            ->value('my-value');

        // Attributes
        $button
            ->title('my title')
            ->id('my-id')
            ->class('my-class')
            ->style('width:100px;height:50px')
            ->content('my content');

        // Data attributes
        $button
            ->data([
                'test1' => 'test1-value',
                'test2' => 'test2-value',
            ]);

        $this->assertEquals('<button type="submit" value="my-value" title="my title" id="my-id" class="my-class" style="width:100px;height:50px" data-test1="test1-value" data-test2="test2-value">my content</button>', (string) $button);
    }
}
