<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Contracts;

use Illuminate\Contracts\Support\Responsable;

interface HalJsonResponseInterface extends Responsable
{
    public function withStatusCode(int $code): self;

    /**
     * @param array<string, mixed> $headers
     */
    public function withHeaders(array $headers): self;

    /**
     * @param array<string, mixed> $content
     */
    public function withContent(array $content): self;
}
