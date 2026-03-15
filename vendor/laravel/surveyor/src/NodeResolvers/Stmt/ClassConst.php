<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassConst extends AbstractResolver
{
    public function resolve(Node\Stmt\ClassConst $node)
    {
        $this->scope->addConstant($node->consts[0]->name, $this->from($node->consts[0]->value));

        return null;
    }
}
