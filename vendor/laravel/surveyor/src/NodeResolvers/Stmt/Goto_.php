<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Goto_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Goto_ $node)
    {
        return null;
    }
}
