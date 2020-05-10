<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Model;
use Nkf\Heroes\Controllers\Games;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

/**
 * Field Model
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property array|null $generate_data
 * @property int $sort_order
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Field whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Field whereGenerateData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Field whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Field whereType($value)
 * @mixin \Eloquent
 * @property-read \October\Rain\Database\Collection|\Nkf\Heroes\Models\Game[] $games
 */
class Field extends Model
{
    use Validation;
    use Sortable;
    use Sluggable;

    public const TYPES = [
        'string' => 'Строка',
        'int' => 'Число',
    ];

    public $timestamps = false;
    public $table = 'nkf_heroes_fields';
    public $slugs = ['code' => 'name'];
    public $rules = [
        'name' => 'required|max:100',
        'type' => 'required|max:100',
    ];
    public $jsonable = ['generate_data'];
    public $belongsToMany = ['games' => Game::class];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'nkf_heroes_fields_games');
    }

    public function getTypeOptions(): array
    {
        return self::TYPES;
    }
}
