<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PHPStan\PhpDocParser\Ast;

class IdentifierTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\IdentifierTypeNode $node)
    {
        $name = (string) $node->name;

        return Type::from($this->scope->getUse($name));
    }
}
