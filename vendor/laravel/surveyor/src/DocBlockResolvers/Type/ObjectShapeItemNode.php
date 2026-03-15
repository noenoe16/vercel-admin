<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ObjectShapeItemNode extends AbstractResolver
{
    public function resolve(Ast\Type\ObjectShapeItemNode $node)
    {
        return null;
    }
}
