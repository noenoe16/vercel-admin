<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class PostInc extends AbstractResolver
{
    public function resolve(Node\Expr\PostInc $node)
    {
        return Type::int();
    }
}
