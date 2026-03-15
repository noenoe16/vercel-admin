<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc\Doctrine;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class DoctrineAnnotation extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\Doctrine\DoctrineAnnotation $node)
    {
        return null;
    }
}
