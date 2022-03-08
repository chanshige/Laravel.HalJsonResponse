<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class HalLink
{
    public function __construct(
        public string $rel = '',
        public string $href = '',
    ) {
    }
}
