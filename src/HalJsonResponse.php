<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Chanshige\Laravel\Http\Contracts\HalJsonResponseInterface;
use Chanshige\Laravel\Http\Contracts\HalLinkInterface;
use Chanshige\Laravel\Http\Extend\AttributeReader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Koriym\HttpConstants\MediaType;
use Koriym\HttpConstants\RequestHeader;
use Koriym\HttpConstants\StatusCode;
use Nocarrier\Hal;
use ReflectionException;
use ReflectionMethod;
use Traversable;

use function array_merge;

final class HalJsonResponse implements HalJsonResponseInterface
{
    private int $code = StatusCode::OK;

    /** @var array<string, string> */
    private array $headers = [RequestHeader::CONTENT_TYPE => MediaType::APPLICATION_HAL];

    /** @var array<string, int|string>  */
    private array $content = [];

    public function __construct(
        private AttributeReader $reader,
        private HalLinkInterface $link
    ) {
    }

    public function withStatusCode(int $code): HalJsonResponseInterface
    {
        $clone = clone $this;
        $clone->code = $code;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withHeaders(array $headers): HalJsonResponseInterface
    {
        $clone = clone $this;
        $clone->headers = array_merge($clone->headers, $headers);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withContent(array $content): HalJsonResponseInterface
    {
        $clone = clone $this;
        $clone->content = $content;

        return $clone;
    }

    /**
     * @param  Request $request
     * @throws ReflectionException
     */
    public function toResponse($request): JsonResponse
    {
        $ref = $this->getReflectionMethod($request->route());
        $attributes = $this->reader->getMethodAttributes($ref);

        $hal = $this->getHal($request, $attributes);

        return JsonResponse::fromJsonString($hal->asJson(true), $this->code, $this->headers);
    }

    /**
     * @param Traversable<int, object> $attributes
     */
    private function getHal(Request $request, Traversable $attributes): Hal
    {
        $qs = ($qs = $request->getQueryString()) !== null ? '?' . $qs : '';
        $hal = new Hal($request->getPathInfo() . $qs, $this->content);

        return $this->link->add($this->content, $attributes, $hal);
    }

    /**
     * @throws ReflectionException
     */
    private function getReflectionMethod(Route $route): ReflectionMethod
    {
        return new ReflectionMethod(
            $route->getController(),
            Str::afterLast($route->getAction('uses'), '@')
        );
    }
}
