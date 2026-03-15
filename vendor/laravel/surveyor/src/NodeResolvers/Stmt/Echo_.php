<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Echo_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Echo_ $node)
    {
        return null;
    }
}
