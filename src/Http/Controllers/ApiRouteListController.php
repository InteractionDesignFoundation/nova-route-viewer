<?php

namespace Sbine\RouteViewer\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Sbine\RouteViewer\Http\Services\RouteMetaInfoProvider;

final class ApiRouteListController
{
    /** Return all the registered routes. */
    public function __invoke(RouteMetaInfoProvider $metaInfoProvider): \Illuminate\Http\JsonResponse
    {
        $routes = collect(Route::getRoutes())->map(static function (\Illuminate\Routing\Route $route) use ($metaInfoProvider): array {
            $routeName = $route->action['as'] ?? '';
            if (Str::endsWith($routeName, '.')) {
                $routeName = '';
            }

            $routeMiddleware = $route->action['middleware'] ?? [];
            if (! is_array($routeMiddleware)) {
                $routeMiddleware = [$routeMiddleware];
            }

            return [
                'uri' => $route->uri,
                'as' => $routeName,
                'methods' => $route->methods,
                'action' => $route->action['uses'] ?? '',
                'middleware' => $routeMiddleware,
                'meta' => $metaInfoProvider->getMeta($route),
            ];
        });

        return response()->json($routes);
    }
}
