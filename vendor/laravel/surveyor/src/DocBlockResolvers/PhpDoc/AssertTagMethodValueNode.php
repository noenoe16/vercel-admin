<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class AssertTagMethodValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\AssertTagMethodValueNode $node)
    {
        return null;
    }
}
