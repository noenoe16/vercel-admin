<?php

namespace Laravel\Surveyor\Types;

class NullType extends AbstractType implements Contracts\Type
{
    public bool $nullable = true;

    public function id(): string
    {
        return 'null';
    }
}
