<?php

namespace Laravel\Surveyor\DocBlockResolvers\Comment;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class Comment extends AbstractResolver
{
    public function resolve(Ast\Comment $node)
    {
        return null;
    }
}
