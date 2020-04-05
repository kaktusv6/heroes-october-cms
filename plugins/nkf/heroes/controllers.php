<?php declare(strict_types=1);

namespace Nkf\Heroes\Controllers;

use Illuminate\Http\JsonResponse;
use Nkf\Heroes\Api\ApiException;
use Nkf\Heroes\Models\Game;
use Nkf\Heroes\Models\User;
use Nkf\Heroes\Models\UsersToken;
use Nkf\Heroes\Utils\PasswordUtils;
use Response;
use Validator;

abstract class ApiController
{
    public function responseJson($data): JsonResponse
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        return response()->json(['errors' => [], 'data' => $data]);
    }

    public function getJsonData()
    {
        return json_decode(request()->getContent(), true);
    }

    public function getValidateJsonData($rules)
    {
        $data = $this->getJsonData();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ApiException($validator->messages()->first());
        }
        return $data;
    }
}

class GamesController extends ApiController
{
    public function games(): JsonResponse
    {
        return $this->responseJson(Game::get()->toArray());
    }
}

class UserController extends ApiController
{
    const RULES_USER = [
        'login' => 'required|alpha_dash',
        'password' => 'required|alpha_dash|min:6|max:16',
    ];

    public function register(): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_USER);
        if (User::whereLogin($data['login'])->first()) {
            throw new ApiException(trans('nkf.heroes::validation.errors.user_already_exist'));
        }
        $user = new User;
        $user->login = $data['login'];
        $user->password = $data['password'];
        $user->save();
        return $this->responseJson(['token' => UsersToken::generateToken($user->id)]);
    }

    public function auth(): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_USER);
        $user = User::whereLogin($data['login'])
            ->wherePassword(PasswordUtils::encodePassword($data['password']))
            ->first();
        if (!$user) {
            throw new ApiException(trans('nkf.heroes::validation.errors.invalid_user'));
        }
        return $this->responseJson(['token' => $user->token->token]);
    }
}

class TestController extends ApiController
{
    public function test(): JsonResponse
    {
        return $this->responseJson(['test success']);
    }
}
