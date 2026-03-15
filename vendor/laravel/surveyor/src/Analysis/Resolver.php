<?php

namespace Laravel\Surveyor\Analysis;

use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\GenericUser;
use Laravel\Surveyor\Types\Type;
use ReflectionClass;

class Resolver
{
    protected $requestUserType = null;

    public function requestUserType()
    {
        return $this->requestUserType ??= $this->resolveRequestUserType();
    }

    protected function resolveRequestUserType()
    {
        $guard = auth()->guard();

        $reflection = new ReflectionClass(get_class($guard));

        if (! $reflection->hasProperty('provider')) {
            return null;
        }

        $property = $reflection->getProperty('provider');
        $provider = $property->getValue($guard);

        if ($provider instanceof EloquentUserProvider) {
            $providerReflection = new ReflectionClass(get_class($provider));
            $modelProperty = $providerReflection->getProperty('model');

            return Type::from($modelProperty->getValue($provider))->nullable();
        }

        if ($provider instanceof DatabaseUserProvider) {
            return Type::from(GenericUser::class)->nullable();
        }

        return null;
    }
}
