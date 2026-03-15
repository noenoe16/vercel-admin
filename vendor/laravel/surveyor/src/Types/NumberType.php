<?php

namespace Laravel\Surveyor\Types;

class NumberType extends AbstractType implements Contracts\Type
{
    public function id(): string
    {
        return 'number';
    }
}
