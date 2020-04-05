<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * hero Model
 *
 * @property int $id
 * @property string $name
 * @property int $game_id
 * @property-read \Nkf\Heroes\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Hero whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Hero whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Hero whereName($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Hero whereUserId($value)
 * @property-read \Nkf\Heroes\Models\User $user
 * @property int|null $home_world_id
 * @property-read \Nkf\Heroes\Models\HomeWorld|null $homeWorld
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\Hero whereHomeWorldId($value)
 * @property-read \October\Rain\Database\Collection|\Nkf\Heroes\Models\Characteristic[] $characteristics
 * @property-read mixed $characteristics_data
 */
class Hero extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_heroes';
    public $rules = [
        'name' => 'required',
        'game_id' => 'required|min:1',
    ];

    public $hasMany = [
        'characteristics' => CharacteristicsHero::class,
    ];

    public function characteristics(): HasMany
    {
        return $this->hasMany(CharacteristicsHero::class);
    }

    public $belongsTo = [
        'game' => Game::class,
        'user' => User::class,
        'homeWorld' => HomeWorld::class,
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function homeWorld(): BelongsTo
    {
        return $this->belongsTo(HomeWorld::class);
    }

    public function getCharacteristicsDataAttribute(): array
    {
        return $this->characteristics->map(function (CharacteristicsHero $characteristic) {
            return [
                'name' => $characteristic->characteristicData->title,
                'value' => $characteristic->value,
            ];
        })->toArray();
    }
}
