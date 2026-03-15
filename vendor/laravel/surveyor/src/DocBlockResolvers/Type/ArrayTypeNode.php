<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PHPStan\PhpDocParser\Ast;

class ArrayTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ArrayTypeNode $node)
    {
        return Type::arrayShape(Type::int(), $this->from($node->type));
    }
}
