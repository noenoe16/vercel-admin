<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PHPStan\PhpDocParser\Ast;

class ObjectShapeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ObjectShapeNode $node)
    {
        $items = [];

        foreach ($node->items as $item) {
            [$key, $value] = $this->resolveItem($item);

            if ($key === null) {
                $items[] = $value;
            } else {
                $items[$key->value] = $value;
            }
        }

        return Type::array($items);
    }

    protected function resolveItem(Ast\Type\ObjectShapeItemNode $item)
    {
        $key = $this->from($item->keyName);
        $value = $this->from($item->valueType);

        if ($item->optional) {
            $value = $key ? $key->optional() : $value->optional();
        }

        return [$key, $value];
    }
}
