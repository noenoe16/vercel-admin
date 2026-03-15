<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class InvalidTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\InvalidTagValueNode $node)
    {
        return null;
    }
}
