<?php

namespace Laravel\Surveyor\Result;

use Laravel\Surveyor\Types\Contracts\Type;

class Variable extends AbstractResult
{
    public function __construct(
        public string $name,
        public Type $type,
        public int $lineNumber,
        public string $scope = 'method',
        public ?Variable $previousState = null,
    ) {
        //
    }

    public function getValueAtLine(int $lineNumber): ?Variable
    {
        if ($this->lineNumber <= $lineNumber) {
            return $this;
        }

        return $this->previousState?->getValueAtLine($lineNumber);
    }
}
