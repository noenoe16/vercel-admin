<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class AssertTagPropertyValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\AssertTagPropertyValueNode $node)
    {
        return null;
    }
}
