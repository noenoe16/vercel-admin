<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class ClosureUse extends AbstractResolver
{
    public function resolve(Node\ClosureUse $node)
    {
        if ($node->byRef) {
            $this->scope->state()->addByReference(
                $node->var,
                $this->from($node->var),
            );
        } else {
            $this->scope->state()->add(
                $node->var,
                $this->from($node->var),
            );
        }
    }
}
