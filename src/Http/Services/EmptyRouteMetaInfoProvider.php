<?php declare(strict_types=1);

namespace Sbine\RouteViewer\Http\Services;

use Illuminate\Routing\Route;

final class EmptyRouteMetaInfoProvider implements RouteMetaInfoProvider
{
    /** @inheritDoc */
    #[\Override]
    public function getMeta(Route $route): array
    {
        return [
            'columns' => [],
        ];
    }
}
