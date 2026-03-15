<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class GenericTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\GenericTagValueNode $node)
    {
        return null;
    }
}
