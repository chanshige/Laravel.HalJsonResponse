<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Fixtures;

use Chanshige\Laravel\Http\Attributes\Link;
use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Illuminate\Routing\Controller;

class FakeHomeAction extends Controller
{
    public function __construct(
        private HalJsonResponseInterface $response
    ) {
    }

    #[Link(rel: 'test', href: '/test')]
    public function __invoke(): HalJsonResponseInterface
    {
        return $this->response->withContent(['message' => 'J.Y.Park']);
    }
}
