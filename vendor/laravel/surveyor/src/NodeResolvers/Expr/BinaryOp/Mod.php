<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Mod extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Mod $node)
    {
        return Type::number();
    }

    public function resolveForCondition(Node\Expr\BinaryOp\Mod $node)
    {
        //
    }
}
