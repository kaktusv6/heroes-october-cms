<?php declare(strict_types=1);

namespace Nkf\Heroes\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Nkf\Heroes\Api\ApiException;
use Nkf\Heroes\Classes\Api\ApiController;
use Nkf\Heroes\HeroFormatter;
use Nkf\Heroes\Models\CharacteristicsHero;
use Nkf\Heroes\Models\Hero;
use Nkf\Heroes\Models\UsersToken;

class HeroController extends ApiController
{
    const RULES_HEROES_USER = [
        'game_id' => 'required|numeric',
    ];

    const RULES_UPDATE = [
        'hero_id' => 'required|numeric|min:1',
        'fields' => 'required|array',
        'fields.*.name' => 'required',
        'fields.*.value' => 'required',
    ];

    const RULES_UPDATE_CHARACTERISTICS = [
        'hero_id' => 'required|numeric|min:1',
        'characteristics' => 'required|array',
        'characteristics.*.id' => 'required|numeric',
        'characteristics.*.value' => 'required|numeric',
    ];

    const RULES_HERO = ['hero_id' => 'required|numeric|min:1'];

    public function heroesUser(Request $request, HeroFormatter $heroFormatter): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_HEROES_USER);
        return $this->responseFormatList(
            UsersToken::whereToken($token = $this->getToken())
                ->first()
                ->user
                ->heroes()
                ->whereGameId($data['game_id'])
                ->first(),
            $heroFormatter
        );
    }

    public function update(Request $request, HeroFormatter $heroFormatter): JsonResponse
    {
        $userIdByToken = UsersToken::whereToken($this->getToken())->first()->user_id;
        $data = $this->getValidateJsonData(self::RULES_UPDATE);
        $hero = Hero::find($data['hero_id']);
        if ($hero->user_id !== $userIdByToken) {
            throw new ApiException(trans('nkf.heroes::validation.errors.hero_not_belong_user'));
        }
        foreach ($data['fields'] as $field) {
            $hero->{$field['name']} = $field['value'];
        }
        $hero->save();
        return $this->responseFormatData($hero, $heroFormatter);
    }

    public function updateCharacteristics(Request $request, HeroFormatter $heroFormatter): JsonResponse
    {
        $userIdByToken = UsersToken::whereToken($this->getToken())->first()->user_id;
        $data = $this->getValidateJsonData(self::RULES_UPDATE_CHARACTERISTICS);
        $hero = Hero::find($data['hero_id']);
        if ($hero->user_id !== $userIdByToken) {
            throw new ApiException(trans('nkf.heroes::validation.errors.hero_not_belong_user'));
        }
        foreach ($data['characteristics'] as $characteristic) {
            /** @var CharacteristicsHero $characteristicHero */
            $characteristicHero = $hero->characteristics()->whereCharacteristicId($characteristic['id'])->first();
            $characteristicHero->value = $characteristic['value'];
            $characteristicHero->save();
        }
        return $this->responseFormatData($hero, $heroFormatter);
    }

    public function remove(): JsonResponse
    {
        $userIdByToken = UsersToken::whereToken($this->getToken())->first()->user_id;
        $data = $this->getValidateJsonData(self::RULES_HERO);
        $hero = Hero::find($data['hero_id']);
        if ($hero->user_id !== $userIdByToken) {
            throw new ApiException(trans('nkf.heroes::validation.errors.hero_not_belong_user'));
        }
        return $this->responseJson(['is_remove' => $hero->delete()]);
    }
}
