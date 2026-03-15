<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class Const_ extends AbstractResolver
{
    public function resolve(Node\Const_ $node)
    {
        return null;
    }
}
