<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class BitwiseNot extends AbstractResolver
{
    public function resolve(Node\Expr\BitwiseNot $node)
    {
        return Type::int();
    }
}
