<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class TraitUse extends AbstractResolver
{
    public function resolve(Node\Stmt\TraitUse $node)
    {
        foreach ($node->traits as $trait) {
            $this->scope->addTrait($trait->toString());
        }

        return null;
    }
}
