<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ArrayShapeItemNode extends AbstractResolver
{
    public function resolve(Ast\Type\ArrayShapeItemNode $node)
    {
        return null;
    }
}
