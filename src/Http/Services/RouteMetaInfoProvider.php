<?php declare(strict_types=1);

namespace Sbine\RouteViewer\Http\Services;

use Illuminate\Routing\Route;

interface RouteMetaInfoProvider
{
    /** @return array{columns: array, ...} */
    public function getMeta(Route $route): array;
}
