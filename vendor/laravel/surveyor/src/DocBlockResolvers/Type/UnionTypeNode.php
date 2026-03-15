<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PHPStan\PhpDocParser\Ast;

class UnionTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\UnionTypeNode $node)
    {
        return Type::union(...array_map(fn ($type) => $this->from($type), $node->types));
    }
}
