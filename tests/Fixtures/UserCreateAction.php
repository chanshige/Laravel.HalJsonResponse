<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Fixtures;

use Chanshige\Laravel\Http\Attributes\HalLink;
use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Illuminate\Container\Container;

class UserCreateAction extends Container
{
    public function __construct(
        private HalJsonResponseInterface $response
    ) {
    }

    #[HalLink(rel: 'user', href: '/users/{id}')]
    public function __invoke(): HalJsonResponseInterface
    {
        return $this->response
            ->withStatusCode(201)
            ->withContent(
                [
                    'id' => 1989,
                    'name' => 'shigeki',
                ]
            );
    }
}
