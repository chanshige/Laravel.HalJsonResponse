<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseTestCase extends TestCase
{
    /** @var Application $app */
    protected $app;

    protected function setUp(): void
    {
        $this->app = new class () extends Container {
            public function runningUnitTests(): bool
            {
                return true;
            }
        };

        $this->registerServiceProvider();

        $this->app->alias('events', EventDispatcher::class);
        $this->app->bind(ContainerInterface::class, Container::class);

        Container::setInstance($this->app);
    }

    protected function mockRun(string $uri, string $action): Response
    {
        $request = Request::create($uri);

        $route = $this->app->make(Router::class)
            ->get($uri, $action)
            ->setContainer($this->app)
            ->bind($request);

        $request->setRouteResolver(static function () use ($route) {
            return $route;
        });

        $action = $this->app->make($action);

        return Router::toResponse($request, $action());
    }

    private function registerServiceProvider(): void
    {
        (new EventServiceProvider($this->app))->register();
        (new HalJsonResponseProvider($this->app))->register();
    }
}
