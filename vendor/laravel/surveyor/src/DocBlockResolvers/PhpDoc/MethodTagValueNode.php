<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class MethodTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\MethodTagValueNode $node)
    {
        $scope = $this->scope->newChildScope();

        $scope->setMethodName($node->methodName);

        if ($node->returnType) {
            $returnTypes = $this->from($node->returnType);

            if ($returnTypes) {
                $scope->addReturnType($returnTypes, -1);
            }
        }
    }
}
