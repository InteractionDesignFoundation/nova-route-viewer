<?php

namespace Sbine\RouteViewer\Http\Controllers;

use App\Modules\Infrastructure\RouteHit\Services\RouteHitCounter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Api
{
    /**
     * Return all the registered routes.
     */
    public function getRoutes(RouteHitCounter $routeHitCounter): \Illuminate\Http\JsonResponse
    {
        $routes = collect(Route::getRoutes())->map(function ($route) use ($routeHitCounter) {
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
                'hits' => $routeHitCounter->getHits($route),
                'action' => $route->action['uses'] ?? '',
                'middleware' => $routeMiddleware,
            ];
        });

        return response()->json($routes);
    }
}
