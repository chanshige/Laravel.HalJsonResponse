<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Fixtures;

use Chanshige\Laravel\Http\Attributes\HalLink;
use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Illuminate\Routing\Controller;

class IndexAction extends Controller
{
    public function __construct(
        private HalJsonResponseInterface $response
    ) {
    }

    #[HalLink(rel: 'user', href: '/users/{user_id}')]
    public function __invoke(): HalJsonResponseInterface
    {
        return $this->response->withContent(
            [
                'message' => 'Hi!',
                'user_id' => 288781,
            ]
        );
    }
}
