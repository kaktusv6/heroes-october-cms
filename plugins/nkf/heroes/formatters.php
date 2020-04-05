<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Nkf\Heroes\Classes\Formatter;
use Nkf\Heroes\Models\Hero;

class HeroFormatter extends Formatter
{
    public function __construct()
    {
        $this->setFormatter(function (Hero $hero) {
            return [
                'name' => $hero->name,
                'homeWorld' => $hero->homeWorld->title,
                'characteristics' => $hero->characteristics_data
            ];
        });
    }
}
