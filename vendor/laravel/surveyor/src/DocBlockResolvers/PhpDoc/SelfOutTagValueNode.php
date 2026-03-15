<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class SelfOutTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\SelfOutTagValueNode $node)
    {
        return $this->from($node->type);
    }
}
