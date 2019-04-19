<?php

namespace ionesculiviucristian\LaravelHtmlForms\Tests\Frameworks\Base;

use Orchestra\Testbench\TestCase;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Option;
use ionesculiviucristian\LaravelHtmlForms\Frameworks\Base\Select;

class SelectTest extends TestCase
{
    /** @test */
    public function it_renders_the_select_correctly(): void
    {
        $select = new class extends Select {
        };

        $select
            ->options([
                1 => 'Test1',
                2 => 'Test2',
                3 => 'Test3',
                4 => 'Test4',
                5 => 'Test5',
            ])
            ->selected([1, 5, 4])
            ->disabled([2, 3, 4]);

        $this->assertEquals('<select><option value="1" selected>Test1</option><option value="2" disabled>Test2</option><option value="3" disabled>Test3</option><option value="4" selected disabled>Test4</option><option value="5" selected>Test5</option></select>', (string) $select);

        $select2 = new class extends Select {
        };

        $select2
            ->options([
                (new Option)->value(1)->setContent('Test1'),
                (new Option)->value(2)->setContent('Test2'),
                (new Option)->value(3)->setContent('Test3'),
                (new Option)->value(4)->setContent('Test4'),
                (new Option)->value(5)->setContent('Test5'),
            ])
            ->selected([1, 5, 4])
            ->disabled([2, 3, 4]);

        $this->assertEquals('<select><option value="1" selected>Test1</option><option value="2" disabled>Test2</option><option value="3" disabled>Test3</option><option value="4" selected disabled>Test4</option><option value="5" selected>Test5</option></select>', (string) $select2);
    }

    /** @test */
    public function it_sets_the_proprieties_correctly()
    {
        $select = new class extends Select {
        };

        $select
            ->options([
                1 => 'Test1',
                2 => 'Test2',
                3 => 'Test3',
                4 => 'Test4',
                5 => 'Test5',
            ])
            ->selected([1, 5, 4])
            ->disabled([2, 3, 4]);

        $this->assertEquals([
            1 => 'Test1',
            2 => 'Test2',
            3 => 'Test3',
            4 => 'Test4',
            5 => 'Test5',
        ], $select->getOptions());

        $this->assertEquals([1, 5, 4], $select->getSelected());

        $this->assertEquals([2, 3, 4], $select->getDisabled());
    }
}
