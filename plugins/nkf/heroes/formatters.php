<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Nkf\Heroes\Classes\Formatter;
use Nkf\Heroes\Models\CharacteristicsHero;
use Nkf\Heroes\Models\Hero;

class CharacteristicsHeroFormatter extends Formatter
{
    public function __construct()
    {
        $this->setFormatter(function (CharacteristicsHero $characteristicsHero) {
            return [
                'name' => $characteristicsHero->characteristicData->title,
                'value' => $characteristicsHero->value,
                'range' => $characteristicsHero->characteristicData->range,
            ];
        });
    }
}

class HeroFormatter extends Formatter
{
    public function __construct(CharacteristicsHeroFormatter $characteristicsHeroFormatter)
    {
        $this->setFormatter(function (Hero $hero) use ($characteristicsHeroFormatter) {
            return [
                'name' => $hero->name,
                'homeWorld' => $hero->homeWorld->title,
                'characteristics' => $characteristicsHeroFormatter->formatList($hero->characteristics),
            ];
        });
    }
}
