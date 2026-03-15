<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class MethodTagValueParameterNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\MethodTagValueParameterNode $node)
    {
        return null;
    }
}
