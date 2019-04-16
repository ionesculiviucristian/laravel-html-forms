<?php

namespace ionesculiviucristian\LaravelHtmlForms\Traits;

trait IsClosedInputTag
{
    protected function setAsClosedInputTag(): void
    {
        $this->tag = 'input';

        $this->closeTag = false;
    }
}
