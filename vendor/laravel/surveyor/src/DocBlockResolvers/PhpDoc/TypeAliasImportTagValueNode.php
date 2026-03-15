<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class TypeAliasImportTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\TypeAliasImportTagValueNode $node)
    {
        return null;
    }
}
