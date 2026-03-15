<?php

namespace Laravel\Surveyor\Types;

use Laravel\Surveyor\Types\Contracts\Type;

class TemplateTagType extends AbstractType
{
    public function __construct(
        public readonly string $name,
        public readonly ?Type $bound,
        public readonly ?Type $default,
        public readonly ?Type $lowerBound,
        public readonly ?string $description,
    ) {
        //
    }

    public function id(): string
    {
        return $this->name;
    }
}
