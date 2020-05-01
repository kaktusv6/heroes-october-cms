<?php declare(strict_types=1);

namespace Nkf\Content;

use Illuminate\Http\Request;
use Nkf\Heroes\Api\ApiException;
use Nkf\Heroes\Models\ApiKey as ApiKeyModel;
use Nkf\Heroes\Models\UsersToken;

abstract class BaseMiddleware
{
    public const ALIAS = '';

    public function handle(Request $request, callable $next)
    {
        return $next($request);
    }
}

class TokenAuthenticate extends BaseMiddleware
{
    public const ALIAS = 'token_auth';

    public function handle(Request $request, callable $next)
    {
        if (UsersToken::whereToken($request->bearerToken())->get()->isEmpty()) {
            throw new ApiException(trans('nkf.heroes::validation.errors.invalid_token'));
        }
        return parent::handle($request, $next);
    }
}

class ApiKey extends BaseMiddleware
{
    public const PARAMETER_API_KEY = 'api_key';
    public const ALIAS = 'api_key';

    public function handle(Request $request, callable $next)
    {
        if (ApiKeyModel::whereApiKey($request->get(self::PARAMETER_API_KEY))->get()->isEmpty()) {
            throw new ApiException('Incorrect or missing api key');
        }
        return parent::handle($request, $next);
    }
}
