<?php

namespace Nkf\Content;

use Illuminate\Http\Request;

abstract class BaseMiddleware
{
    public function handle(Request $request, callable $next): void
    {
        return $next($request);
    }
}

class Authorization extends BaseMiddleware
{

    public function handle(Request $request, callable $next): void
    {

        parent::handle($request, $next);
    }
}
