<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class TypeAliasTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\TypeAliasTagValueNode $node)
    {
        return null;
    }
}
