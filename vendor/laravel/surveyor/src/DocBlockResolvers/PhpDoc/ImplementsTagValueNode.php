<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ImplementsTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ImplementsTagValueNode $node)
    {
        return $this->from($node->type);
    }
}
