<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ParamClosureThisTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ParamClosureThisTagValueNode $node)
    {
        return null;
    }
}
