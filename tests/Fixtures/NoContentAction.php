<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Fixtures;

use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Illuminate\Routing\Controller;

class NoContentAction extends Controller
{
    public function __construct(
        private HalJsonResponseInterface $response
    ) {
    }

    public function __invoke(): HalJsonResponseInterface
    {
        return $this->response->withStatusCode(204);
    }
}
