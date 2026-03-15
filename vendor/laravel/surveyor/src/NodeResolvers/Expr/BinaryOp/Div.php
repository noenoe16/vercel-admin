<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Div extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Div $node)
    {
        return Type::number();
    }
}
