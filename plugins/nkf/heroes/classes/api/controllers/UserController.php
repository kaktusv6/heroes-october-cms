<?php declare(strict_types=1);

namespace Nkf\Heroes\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Nkf\Heroes\Api\ApiException;
use Nkf\Heroes\Classes\Api\ApiController;
use Nkf\Heroes\Models\User;
use Nkf\Heroes\Models\UsersToken;
use Nkf\Heroes\Utils\PasswordUtils;

class UserController extends ApiController
{
    const RULES_USER = [
        'login' => 'required|alpha_dash',
        'password' => 'required|min:6|max:16',
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
        $user = User::whereLogin($data['login'])->first();
        if ($user === null) {
            throw new ApiException(trans('nkf.heroes::validation.errors.undefined_user_login'));
        }
        if ($user->password !== PasswordUtils::encodePassword($data['password'])) {
            throw new ApiException(trans('nkf.heroes::validation.errors.invalid_password'));
        }
        return $this->responseJson(['token' => $user->token->token]);
    }
}
