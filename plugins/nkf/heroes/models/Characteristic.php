<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use October\Rain\Database\Relations\MorphMany;
use \October\Rain\Database\Traits\Validation;
use Model;

/**
 * Model
 *
 * @property string|null $description
 * @property int $game_id
 * @property int $id
 * @property string $range
 * @property string $range_generator
 * @property string $title
 * @property-read \Nkf\Heroes\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Characteristic whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Characteristic whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Characteristic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Characteristic whereRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Characteristic whereRangeGenerator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Characteristic whereTitle($value)
 * @mixin \Eloquent
 */
class Characteristic extends Model
{
    use Validation;
    public $timestamps = false;

    public $table = 'nkf_heroes_characteristics';

    public $rules = [
        'title' => 'required',
        'range' => 'required',
        'range_generator' => 'required',
    ];
    public $jsonable = [
        'range',
        'range_generator',
    ];

    public $belongsTo = ['game' => Game::class];
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public $morphToMany = [
        'games' => [Game::class, 'table' => 'nkf_heroes_properties_games', 'name' => 'property']
    ];
}
