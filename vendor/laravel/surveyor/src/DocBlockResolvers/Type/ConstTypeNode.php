<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ConstTypeNode $node)
    {
        return $this->from($node->constExpr);
    }
}
