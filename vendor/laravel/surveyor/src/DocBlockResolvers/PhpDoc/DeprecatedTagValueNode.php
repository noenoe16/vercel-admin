<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class DeprecatedTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\DeprecatedTagValueNode $node)
    {
        return null;
    }
}
