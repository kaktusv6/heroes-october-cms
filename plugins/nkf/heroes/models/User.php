<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Model;
use Nkf\Heroes\Utils\PasswordUtils;
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
 * @property-read \October\Rain\Database\Collection|\Nkf\Heroes\Models\Hero[] $heroes
 * @property-read \Nkf\Heroes\Models\UsersToken $token
 */
class User extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_users';
    public $rules = [
        'login' => 'required|alpha_dash|min:3',
        'password' => 'required',
    ];

    public function beforeSave(): void
    {
        if (object_get($this, 'id', null) === null) {
            $this->password = PasswordUtils::encodePassword($this->password);
        }
    }

    public $hasMany = ['heroes' => Hero::class];
    public function heroes(): HasMany
    {
        return $this->hasMany(Hero::class);
    }

    public $hasOne = ['token' => UsersToken::class];
    public function token(): HasOne
    {
        return $this->hasOne(UsersToken::class);
    }
}
