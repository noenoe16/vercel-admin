<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class OffsetAccessTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\OffsetAccessTypeNode $node)
    {
        return null;
    }
}
