<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;

/**
 * Professional Model
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string|null $condition
 * @property-read \October\Rain\Database\Collection|\Nkf\Heroes\Models\Game[] $games
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Professional whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Professional whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Professional whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Professional whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Professional whereCondition($value)
 * @mixin \Eloquent
 */
class Professional extends Model
{
    use Validation;
    use Sluggable;

    public $timestamps = false;
    public $table = 'nkf_heroes_professionals';
    public $rules = [
        'name' => 'required|max:250',
    ];
    public $slugs = ['code' => 'name'];
    public $belongsToMany = ['games' => Game::class];
    public $jsonable = ['condition'];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'nkf_heroes_professionals_games');
    }
}
