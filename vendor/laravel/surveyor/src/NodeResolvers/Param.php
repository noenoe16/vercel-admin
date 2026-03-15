<?php

namespace Laravel\Surveyor\NodeResolvers;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Surveyor\Concerns\LazilyLoadsDependencies;
use Laravel\Surveyor\Types\ClassType;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Param extends AbstractResolver
{
    use LazilyLoadsDependencies;

    public function resolve(Node\Param $node)
    {
        $type = $this->resolveType($node);

        if ($node->variadic) {
            $type = Type::arrayShape(Type::int(), $type);
        }

        $this->scope->result()?->addParameter($node->var->name, $type);

        $this->scope->state()->add(
            $node,
            $type,
        );

        if (Type::is($type, ClassType::class) && is_subclass_of($type->value, FormRequest::class)) {
            $analyzed = $this->getAnalyzer()->analyze($this->reflector->reflectClass($type->value)->getFileName());
            $validationRules = $analyzed->analyzed()->result()->getMethod('rules')?->validationRules() ?? [];

            foreach ($validationRules as $key => $rules) {
                $this->scope->result()->addValidationRule($key, $rules);
            }
        }

        return null;
    }

    protected function resolveType(Node\Param $node)
    {
        $results = [];

        if ($this->scope->entityName() && $this->scope->methodName()) {
            $result = $this->reflector->paramType($node, $this->scope->entityName(), $this->scope->methodName());

            if ($result) {
                $results[] = $result;
            }
        }

        if ($node->type) {
            $results[] = $this->from($node->type);
        }

        if (empty($results)) {
            return Type::mixed();
        }

        return Type::union(...$results);
    }
}
