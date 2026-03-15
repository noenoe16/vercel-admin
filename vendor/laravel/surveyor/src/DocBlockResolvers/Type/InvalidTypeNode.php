<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class InvalidTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\InvalidTypeNode $node)
    {
        return null;
    }
}
