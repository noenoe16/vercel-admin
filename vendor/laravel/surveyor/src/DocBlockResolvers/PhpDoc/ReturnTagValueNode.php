<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ReturnTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ReturnTagValueNode $node)
    {
        return $this->from($node->type);
    }
}
