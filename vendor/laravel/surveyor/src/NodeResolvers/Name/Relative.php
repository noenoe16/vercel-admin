<?php

namespace Laravel\Surveyor\NodeResolvers\Name;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Relative extends AbstractResolver
{
    public function resolve(Node\Name\Relative $node)
    {
        return $this->scope->getUse($node->name);
    }
}
