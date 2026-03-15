<?php

namespace Laravel\Surveyor\Result;

class ClassMethodDeclaration extends AbstractResult
{
    public function __construct(
        public string $name,
        public array $parameters,
        public array $returnTypes,
    ) {
        //
    }
}
