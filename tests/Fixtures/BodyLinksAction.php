<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Fixtures;

use Chanshige\Laravel\Http\Attributes\HalLink;
use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Illuminate\Routing\Controller;

class BodyLinksAction extends Controller
{
    public function __construct(
        private HalJsonResponseInterface $response
    ) {
    }

    #[HalLink(rel: 'test', href: '/attribute_link')]
    public function __invoke(): HalJsonResponseInterface
    {
        return $this->response->withContent(
            [
                'greeting' => 'Hi! hyper media.',
                '_links' => [
                    'test' => ['href' => '/body_link'],
                    'bttf' => ['href' => '/back_in_time'],
                ],
            ]
        );
    }
}
