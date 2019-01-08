<?php

namespace Ansezz\CategoriesField\Http\Middleware;

use Ansezz\CategoriesField\Categories;
use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        //TODO: see if this is necessary

        return $next($request);

        return app(Categories::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
