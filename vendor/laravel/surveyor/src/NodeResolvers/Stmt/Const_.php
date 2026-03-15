<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Const_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Const_ $node)
    {
        foreach ($node->consts as $const) {
            $this->scope->addConstant($const->name, $this->from($const->value));
        }

        return null;
    }
}
