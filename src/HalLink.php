<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http;

use Chanshige\Laravel\Http\Attributes\Link;
use Chanshige\Laravel\Http\Contracts\HalLinkInterface;
use Chanshige\Laravel\Http\Extend\UriTemplate;
use Nocarrier\Hal;
use Traversable;

final class HalLink implements HalLinkInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(array $body, Traversable $attributes, Hal $hal): Hal
    {
        $hal = $this->attributeLink($body, $attributes, $hal);

        if (isset($body['_links'])) {
            return $this->bodyLink($body, $hal);
        }

        return $hal;
    }

    /**
     * @param array<int, mixed>        $body
     * @param Traversable<int, object> $attributes
     */
    private function attributeLink(array $body, Traversable $attributes, Hal $hal): Hal
    {
        foreach ($attributes as $attribute) {
            if (!$attribute instanceof Link) {
                continue;
            }

            if (isset($body['_links'][$attribute->rel])) {
                continue;
            }

            $hal->addLink($attribute->rel, UriTemplate::expand($attribute->href, $body));
        }

        return $hal;
    }

    /**
     * @param array{_links: array<string, array{href: string}>} $body
     */
    private function bodyLink(array $body, Hal $hal): Hal
    {
        foreach ($body['_links'] as $rel => $link) {
            if (!isset($link['href'])) {
                continue;
            }

            $attr = $link;
            unset($attr['href']);
            $hal->addLink($rel, UriTemplate::expand($link['href'], $body), $attr);
        }

        return $hal;
    }
}
