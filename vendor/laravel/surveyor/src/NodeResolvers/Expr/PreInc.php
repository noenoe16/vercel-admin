<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class PreInc extends AbstractResolver
{
    public function resolve(Node\Expr\PreInc $node)
    {
        return Type::int();
    }
}
