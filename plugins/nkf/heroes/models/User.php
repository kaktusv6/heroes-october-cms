<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * User Model
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\User wherePassword($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_users';
    public $rules = [
        'login' => 'required',
        'password' => 'required',
    ];

    public $hasMany = ['heroes' => Hero::class];
    public function heroes(): HasMany
    {
        return $this->hasMany(Hero::class);
    }
}
