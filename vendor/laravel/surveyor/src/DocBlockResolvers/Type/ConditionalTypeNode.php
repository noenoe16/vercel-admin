<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PHPStan\PhpDocParser\Ast;

class ConditionalTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ConditionalTypeNode $node)
    {
        return Type::union($this->from($node->if), $this->from($node->else));
    }
}
