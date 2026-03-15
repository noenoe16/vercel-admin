<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Exit_ extends AbstractResolver
{
    public function resolve(Node\Expr\Exit_ $node)
    {
        $this->scope->state()->markSnapShotAsTerminated($node);

        $type = $this->from($node->expr);

        if ($type !== null) {
            $this->scope->addReturnType(Type::collapse($type), $node->getStartLine());
        }

        return null;
    }
}
