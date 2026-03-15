<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class SealedTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\SealedTagValueNode $node)
    {
        return null;
    }
}
