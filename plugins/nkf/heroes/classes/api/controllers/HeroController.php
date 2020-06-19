<?php declare(strict_types=1);

namespace Nkf\Heroes\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Nkf\Heroes\Api\ApiException;
use Nkf\Heroes\CharacteristicsHeroFormatter;
use Nkf\Heroes\Classes\Api\ApiController;
use Nkf\Heroes\FieldHeroFormatter;
use Nkf\Heroes\HeroFormatter;
use Nkf\Heroes\Models\Characteristic;
use Nkf\Heroes\Models\CharacteristicsHero;
use Nkf\Heroes\Models\Field;
use Nkf\Heroes\Models\FieldsHero;
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

    const RULES_HERO_NAME = [
        'hero_id' => 'required|numeric|min:1',
        'name' => 'required',
    ];

    const RULES_CHARACTERISTIC = [
        'hero_id' => 'required|numeric',
        'characteristic_id' => 'required|numeric',
        'value' => 'required|numeric',
    ];

    const RULES_FIELD = [
        'hero_id' => 'required|numeric',
        'code' => 'required',
        'value' => 'required',
    ];

    protected function checkHeroUser(Hero $hero): void
    {
        if ($hero->user_id !== $this->getUserIdByToken()) {
            throw new ApiException(trans('nkf.heroes::validation.errors.hero_not_belong_user'));
        }
    }

    public function heroes(HeroFormatter $heroFormatter): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_HEROES_USER);
        return $this->responseFormatList(
            UsersToken::whereToken($token = $this->getToken())
                ->first()
                ->user
                ->heroes()
                ->whereGameId($data['game_id'])
                ->get(),
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

    public function updateName(): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_HERO_NAME);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        $hero->name = $data['name'];
        $hero->save();
        return $this->responseSuccess();
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

    public function updateCharacteristic(): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_CHARACTERISTIC);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        $characteristic = Characteristic::find($data['characteristic_id']);
        /** @var CharacteristicsHero $characteristicValue */
        $characteristicValue = $hero->characteristics()->whereCharacteristicId($characteristic->id)->first();
        $characteristicValue->value = (int)$data['value'];
        $characteristicValue->save();
        return $this->responseSuccess();
    }

    public function updateField(FieldHeroFormatter $formatter): JsonResponse
    {
        $data = $this->getValidateJsonData(self::RULES_FIELD);
        $hero = Hero::find($data['hero_id']);
        $this->checkHeroUser($hero);
        $field = Field::whereCode($data['code'])->first();
        /** @var FieldsHero $fieldValue */
        $fieldValue = $hero->fields()->whereFieldId($field->id)->first();
        $fieldValue->value = $data['value'];
        $fieldValue->save();
        return $this->responseFormatData($fieldValue, $formatter);
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
