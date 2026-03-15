<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Property extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Property $node)
    {
        return Type::string();
    }
}
