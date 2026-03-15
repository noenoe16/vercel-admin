<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class Attribute extends AbstractResolver
{
    public function resolve(Node\Attribute $node)
    {
        $attributeType = $this->from($node->name);

        $resolvedArgs = array_map(
            fn ($arg) => $this->from($arg->value),
            $node->args
        );

        return $attributeType;
    }
}
