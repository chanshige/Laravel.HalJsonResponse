<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Chanshige\Laravel\Http\Contracts\HalLinkInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class HalJsonResponseProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->bind(HalLinkInterface::class, HalLink::class);
        $this->app->bind(HalJsonResponseInterface::class, HalJsonResponse::class);
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [HalJsonResponseInterface::class];
    }
}
