<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Model;

/**
 * CharacteristicsHero Model
 *
 * @property int $hero_id
 * @property int $characteristic_id
 * @property int $value
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\CharacteristicsHero whereCharacteristicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\CharacteristicsHero whereHeroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\CharacteristicsHero whereValue($value)
 * @mixin \Eloquent
 * @property-read \Nkf\Heroes\Models\Characteristic $characteristicData
 */
class CharacteristicsHero extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['hero_id', 'characteristic_id'];
    public $table = 'nkf_heroes_properties_heroes';

    public $belongsTo = [
        'characteristicData' => Characteristic::class,
    ];

    public function characteristicData(): BelongsTo
    {
        return $this->belongsTo(Characteristic::class, 'characteristic_id');
    }

    protected function setKeysForSaveQuery(Builder $query): Builder
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param null $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if ($keyName === null) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
