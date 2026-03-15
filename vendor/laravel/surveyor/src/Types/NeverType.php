<?php

namespace Laravel\Surveyor\Types;

class NeverType extends AbstractType implements Contracts\Type
{
    public function id(): string
    {
        return 'never';
    }
}
