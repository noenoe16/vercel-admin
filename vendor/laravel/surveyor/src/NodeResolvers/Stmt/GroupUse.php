<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class GroupUse extends AbstractResolver
{
    public function resolve(Node\Stmt\GroupUse $node)
    {
        $prefix = $node->prefix->toString();

        foreach ($node->uses as $use) {
            $this->scope->addUse(
                $prefix.'\\'.$use->name->toString(),
                $use->alias ? $prefix.'\\'.$use->alias?->name : null,
            );
        }

        return null;
    }
}
