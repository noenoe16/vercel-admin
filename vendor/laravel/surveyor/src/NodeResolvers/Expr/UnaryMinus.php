<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Contracts\MultiType;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class UnaryMinus extends AbstractResolver
{
    public function resolve(Node\Expr\UnaryMinus $node)
    {
        $result = $this->from($node->expr);

        if ($result instanceof MultiType) {
            return Type::union(...array_map(fn ($type) => $type->value * -1, $result->types));
        }

        if (! property_exists($result, 'value') || $result->value === null) {
            return $result;
        }

        $type = get_class($result);

        return new $type($result->value * -1);
    }
}
