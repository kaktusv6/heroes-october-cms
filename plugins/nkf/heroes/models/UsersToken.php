<?php namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * UsersToken Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Nkf\Heroes\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\UsersToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\UsersToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\UsersToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\UsersToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\UsersToken whereUserId($value)
 * @mixin \Eloquent
 */
class UsersToken extends Model
{
    use Validation;

    public $table = 'nkf_heroes_users_tokens';
    public $rules = [
        'token' => 'required',
        'user_id' => 'required|min:1',
    ];

    public $belongsTo = ['user' => User::class];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
