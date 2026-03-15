<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc\Doctrine;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class DoctrineArgument extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\Doctrine\DoctrineArgument $node)
    {
        return null;
    }
}
