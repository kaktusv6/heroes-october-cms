<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * HomeWorld Model
 *
 * @property int $id
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\HomeWorld whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\HomeWorld whereTitle($value)
 * @mixin \Eloquent
 */
class HomeWorld extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_home_worlds';
    public $rules = ['title' => 'required'];

    public $morphToMany = ['games' => [Game::class, 'table' => 'nkf_heroes_properties_games', 'name' => 'property']];
}
