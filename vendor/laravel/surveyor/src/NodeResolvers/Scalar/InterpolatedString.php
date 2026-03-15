<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class InterpolatedString extends AbstractResolver
{
    public function resolve(Node\Scalar\InterpolatedString $node)
    {
        return Type::string();
    }
}
