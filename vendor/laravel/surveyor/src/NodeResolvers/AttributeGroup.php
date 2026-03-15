<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class AttributeGroup extends AbstractResolver
{
    public function resolve(Node\AttributeGroup $node)
    {
        foreach ($node->attrs as $attribute) {
            $this->from($attribute);
        }

        return null;
    }
}
