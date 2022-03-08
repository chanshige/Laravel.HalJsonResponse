<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Extend;

use ReflectionMethod;
use Traversable;

class AttributeReader
{
    /**
     * @return Traversable<int, object>
     */
    public function getMethodAttributes(ReflectionMethod $method): Traversable
    {
        foreach ($method->getAttributes() as $ref) {
            yield $ref->newInstance();
        }
    }
}
