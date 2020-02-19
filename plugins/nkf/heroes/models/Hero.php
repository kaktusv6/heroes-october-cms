<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public $belongsTo = [
        'game' => Game::class,
        'user' => User::class,
    ];
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
