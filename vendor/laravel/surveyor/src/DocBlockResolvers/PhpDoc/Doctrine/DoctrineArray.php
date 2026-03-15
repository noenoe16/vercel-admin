<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc\Doctrine;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class DoctrineArray extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\Doctrine\DoctrineArray $node)
    {
        return null;
    }
}
