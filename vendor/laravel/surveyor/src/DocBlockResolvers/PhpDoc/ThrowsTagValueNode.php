<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ThrowsTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ThrowsTagValueNode $node)
    {
        return null;
    }
}
