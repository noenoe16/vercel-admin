<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc\Doctrine;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class DoctrineArrayItem extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\Doctrine\DoctrineArrayItem $node)
    {
        return null;
    }
}
