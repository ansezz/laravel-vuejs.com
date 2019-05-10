<?php

namespace Ansezz\WpImporter\Http\Middleware;

use Ansezz\WpImporter\WpImporter;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(WpImporter::class)->authorize($request) ? $next($request) : abort(403);
    }
}
