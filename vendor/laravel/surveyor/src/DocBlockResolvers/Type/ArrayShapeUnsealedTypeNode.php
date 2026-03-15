<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PHPStan\PhpDocParser\Ast;

class ArrayShapeUnsealedTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ArrayShapeUnsealedTypeNode $node)
    {
        return Type::arrayShape($this->from($node->keyType), $this->from($node->valueType));
    }
}
