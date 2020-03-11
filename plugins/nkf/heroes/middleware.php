<?php declare(strict_types=1);

namespace Nkf\Content;

use Illuminate\Http\Request;

abstract class BaseMiddleware
{
    public function handle(Request $request, callable $next): void
    {
        return $next($request);
    }
}

class TokenAuthenticate extends BaseMiddleware
{

    public function handle(Request $request, callable $next): void
    {
        if ($request->cookie('token_user')) {
            // todo check user by token
        }
        parent::handle($request, $next);
    }
}
