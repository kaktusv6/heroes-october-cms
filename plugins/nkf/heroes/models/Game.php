<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Nkf\Heroes\Models\Game
 *
 * @property string|null $description
 * @property int $id
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Game whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Game whereTitle($value)
 * @mixin \Eloquent
 * @property string|null $properties
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Game whereProperties($value)
 */
class Game extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_games';
    public $rules = [
        'title' => 'required|max:255',
    ];

    public $morphedByMany = [
        'characteristics' => [Characteristic::class, 'table' => 'nkf_heroes_properties_games', 'name' => 'property'],
    ];
}
