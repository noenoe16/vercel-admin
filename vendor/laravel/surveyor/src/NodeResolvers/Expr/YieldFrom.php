<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class YieldFrom extends AbstractResolver
{
    public function resolve(Node\Expr\YieldFrom $node)
    {
        return null;
    }
}
