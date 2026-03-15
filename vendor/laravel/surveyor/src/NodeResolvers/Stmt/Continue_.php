<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Continue_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Continue_ $node)
    {
        return null;
    }
}
