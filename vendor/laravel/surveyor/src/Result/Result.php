<?php

namespace Laravel\Surveyor\Result;

class Result
{
    protected array $statements = [];

    public function __construct(
        protected string $path,
    ) {
        //
    }
}
