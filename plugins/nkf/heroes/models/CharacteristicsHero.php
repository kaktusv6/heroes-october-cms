<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Model;
use Nkf\Heroes\Classes\Traits\SaveValueRelationship;

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
    use SaveValueRelationship;

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
}
