<?php declare(strict_types=1);

namespace Nkf\Heroes\Api\Controllers;

use Illuminate\Http\JsonResponse;
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

    const RULES_CHARACTERISTIC = [
        'hero_id' => 'required|numeric',
        'code' => 'required',
        'value' => 'required|numeric',
    ];

    protected function checkHeroUser(Hero $hero): void
    {
        if ($hero->user_id !== $this->getUserIdByToken()) {
            throw new ApiException(trans('nkf.heroes::validation.errors.hero_not_belong_user'));
        }
    }

    public function heroesUser(HeroFormatter $heroFormatter): JsonResponse
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

    public function hero(HeroFormatter $heroFormatter): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_HERO);
        return $this->responseFormatData(
            UsersToken::whereToken($this->getToken())->first()->user->heroes()->whereId($data['hero_id'])->first(),
            $heroFormatter
        );
    }

    public function update(HeroFormatter $heroFormatter): JsonResponse
    {
        $userIdByToken = UsersToken::whereToken($this->getToken())->first()->user_id;
        $data = $this->getValidateJsonData(self::RULES_UPDATE);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        foreach ($data['properties'] as $property) {
            $hero->{$property['name']} = $property['value'];
        }
        $hero->save();
        return $this->responseFormatData($hero, $heroFormatter);
    }

    public function updateCharacteristics(HeroFormatter $heroFormatter): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_UPDATE_CHARACTERISTICS);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        foreach ($data['characteristics'] as $characteristic) {
            /** @var CharacteristicsHero $characteristicHero */
            $characteristicHero = $hero->characteristics()->whereCharacteristicId($characteristic['id'])->first();
            $characteristicHero->value = $characteristic['value'];
            $characteristicHero->save();
        }
        return $this->responseFormatData($hero, $heroFormatter);
    }

    public function updateCharacteristic(CharacteristicsHeroFormatter $formatter): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_CHARACTERISTIC);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        $characteristic = Characteristic::whereSlug($data['code'])->first();
        /** @var CharacteristicsHero $characteristicValue */
        $characteristicValue = $hero->characteristics()->whereCharacteristicId($characteristic->id)->first();
        $characteristicValue->value = (int)$data['value'];
        $characteristicValue->save();
        return $this->responseFormatData($characteristicValue, $formatter);
    }

    public function remove(): JsonResponse
    {
        $userIdByToken = UsersToken::whereToken($this->getToken())->first()->user_id;
        $data = $this->getValidateJsonData(self::RULES_HERO);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        return $this->responseJson(['is_remove' => $hero->delete()]);
    }
}
