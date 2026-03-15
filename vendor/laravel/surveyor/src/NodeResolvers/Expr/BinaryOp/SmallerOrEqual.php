<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class SmallerOrEqual extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\SmallerOrEqual $node)
    {
        return Type::bool();
    }

    public function resolveForCondition(Node\Expr\BinaryOp\SmallerOrEqual $node)
    {
        return null;
    }
}
