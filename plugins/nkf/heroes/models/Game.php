<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Support\Facades\DB;
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
 */
class Game extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_games';
    public $rules = [
        'title' => 'required|max:255',
    ];
    public $jsonable = ['entities'];

    public function getEntityOptions(): array
    {
        return DB::table('information_schema.COLUMNS')
            ->select('TABLE_NAME')
            ->where('TABLE_SCHEMA', 'LIKE', 'heroes', 'and')
            ->where('COLUMN_NAME', 'LIKE', 'game_id')->get()
            ->map(function ($val) {
                return $val->TABLE_NAME;
            })->toArray();
    }
}
