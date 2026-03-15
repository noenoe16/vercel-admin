<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class TypelessParamTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\TypelessParamTagValueNode $node)
    {
        return null;
    }
}
