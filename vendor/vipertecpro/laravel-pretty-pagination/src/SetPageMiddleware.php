<?php

namespace Vipertecpro\PaginateRoute;

use Request;
use Route;
use Closure;
use Illuminate\Pagination\Paginator;

class SetPageMiddleware
{
    /**
     * Set the current page based on the page route parameter before the route's action is executed.
     *
     * @param $request
     * @param Closure $next
     * @return Request
     */
    public function handle($request, Closure $next)
    {
        Paginator::currentPageResolver(function () {
            return app('paginateroute')->currentPage();
        });

        return $next($request);
    }
}
