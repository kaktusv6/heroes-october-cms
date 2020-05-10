<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @property-read \Nkf\Heroes\Models\Field $fields
 */
class Game extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_games';
    public $rules = [
        'title' => 'required|max:255',
    ];
    public $belongsToMany = [
        'fields' => Field::class,
        'characteristics' => Characteristic::class,
        'home_worlds' => HomeWorld::class,
    ];

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class, 'nkf_heroes_fields_games');
    }

    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class, 'nkf_heroes_characteristics_games');
    }

    public function home_worlds(): BelongsToMany
    {
        return $this->belongsToMany(HomeWorld::class, 'nkf_heroes_home_worlds_games');
    }
}
