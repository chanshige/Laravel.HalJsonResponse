<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Contracts;

use Illuminate\Contracts\Support\Responsable;

interface HalJsonResponseInterface extends Responsable
{
    /**
     * @param array<string, mixed> $headers
     */
    public function withHeaders(array $headers): self;

    public function withStatusCode(int $code): self;

    public function withContent(mixed $content): self;
}
