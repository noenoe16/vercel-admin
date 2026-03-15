<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class UsesTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\UsesTagValueNode $node)
    {
        return null;
    }
}
