<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Support\Collection;
use Model;
use October\Rain\Database\Traits\Validation;
use Str;

/**
 * ApiKey Model
 *
 * @property string $api_key
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\ApiKey whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\ApiKey whereId($value)
 * @mixin \Eloquent
 */
class ApiKey extends Model
{
    use Validation;

    public $timestamps = false;
    public $table = 'nkf_heroes_api_keys';
    public $rules = [
        'api_key' => 'max:10|unique:nkf_heroes_api_keys',
    ];

    public function beforeSave(): void
    {
        if ($this->api_key === '' || $this->api_key === null) {
            $this->api_key = self::generateApiKey();
        }
    }

    public static function generateApiKey(): string
    {
        /** @var Collection $allKeys */
        $allKeys = self::get();
        $key = Str::random(10);
        while ($allKeys->contains('api_key', $key)) {
            $key = Str::random(10);
        }
        return $key;
    }
}
