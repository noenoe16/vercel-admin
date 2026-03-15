<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\AssignOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Concat extends AbstractResolver
{
    public function resolve(Node\Expr\AssignOp\Concat $node)
    {
        return Type::string();
    }
}
