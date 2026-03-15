<?php

namespace Laravel\Surveyor\NodeResolvers\Name;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Support\Util;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class FullyQualified extends AbstractResolver
{
    public function resolve(Node\Name\FullyQualified $node)
    {
        return $this->resolveName($node);
    }

    public function resolveForCondition(Node\Name\FullyQualified $node)
    {
        return $this->resolveName($node);
    }

    protected function resolveName(Node\Name\FullyQualified $node)
    {
        $className = Util::resolveValidClass($node->toString(), $this->scope);

        if (! Util::isClassOrInterface($className) && $node->toString() !== $node->getAttribute('originalName')) {
            $className = $this->scope->resolveBuggyUse($node->getAttribute('originalName'));
        }

        return Type::from($className);
    }
}
