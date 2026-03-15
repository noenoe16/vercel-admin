<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\Analysis\Condition;
use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Coalesce extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Coalesce $node)
    {
        $left = $this->from($node->left);
        $right = $this->from($node->right);

        if ($left instanceof Condition) {
            $left = $left->apply();
        }

        if ($right instanceof Condition) {
            $right = $right->apply();
        }

        return Type::union($left, $right);
    }

    public function resolveForCondition(Node\Expr\BinaryOp\Coalesce $node)
    {
        return $this->resolve($node);
    }
}
