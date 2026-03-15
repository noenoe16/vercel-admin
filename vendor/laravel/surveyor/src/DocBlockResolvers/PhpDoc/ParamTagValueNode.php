<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ParamTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ParamTagValueNode $node)
    {
        return $this->from($node->type);
    }
}
