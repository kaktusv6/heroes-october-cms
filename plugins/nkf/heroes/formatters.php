<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Nkf\Heroes\Classes\Formatter;
use Nkf\Heroes\Models\CharacteristicsHero;
use Nkf\Heroes\Models\FieldsHero;
use Nkf\Heroes\Models\Hero;

class CharacteristicsHeroFormatter extends Formatter
{
    public function __construct()
    {
        $this->setFormatter(function (CharacteristicsHero $characteristicsHero) {
            return [
                'id' => $characteristicsHero->characteristicData->id,
                'name' => $characteristicsHero->characteristicData->title,
                'code' => $characteristicsHero->characteristicData->slug,
                'value' => $characteristicsHero->value,
                'range' => $characteristicsHero->characteristicData->range,
            ];
        });
    }
}

class FieldHeroFormatter extends Formatter
{
    public function __construct()
    {
        $this->setFormatter(function (FieldsHero $fieldsHero) {
            return [
                'name' => $fieldsHero->field->name,
                'type' => $fieldsHero->field->type,
                'value' => $fieldsHero->value,
            ];
        });
    }
}

class HeroFormatter extends Formatter
{
    public function __construct(
        CharacteristicsHeroFormatter $characteristicsHeroFormatter,
        FieldHeroFormatter $fieldHeroFormatter
    ) {
        $this->setFormatter(function (Hero $hero) use (
            $characteristicsHeroFormatter,
            $fieldHeroFormatter
        ) {
            return [
                'id' => $hero->id,
                'name' => $hero->name,
                'properties' => [
                    'homeWorld' => $hero->homeWorld->title,
                ],
                'characteristics' => $characteristicsHeroFormatter->formatList($hero->characteristics),
                'fields' => $fieldHeroFormatter->formatList($hero->fields),
            ];
        });
    }
}
