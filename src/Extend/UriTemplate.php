<?php

declare(strict_types=1);

namespace Chanshige\Laravel\Http\Extend;

final class UriTemplate
{
    /**
     * @param array<int, mixed> $variables
     */
    public static function expand(string $template, array $variables): string
    {
        static $uriTemplate;

        if (! $uriTemplate) {
            $uriTemplate = new \Rize\UriTemplate();
        }

        return $uriTemplate->expand($template, $variables);
    }
}
