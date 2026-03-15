<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Namespace_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Namespace_ $node)
    {
        $this->scope->setNamespace($node->name->name);

        return null;
    }
}
