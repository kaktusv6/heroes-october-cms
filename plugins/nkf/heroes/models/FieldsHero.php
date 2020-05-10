<?php declare(strict_types=1);

namespace Nkf\Heroes\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Model;

/**
 * FieldData Model
 *
 * @mixin \Eloquent
 * @property int $field_id
 * @property int $hero_id
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\FieldsHero whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\FieldsHero whereHeroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Nkf\Heroes\Models\FieldsHero whereValue($value)
 * @property-read \Nkf\Heroes\Models\Hero $hero
 * @property-read \Nkf\Heroes\Models\Field $fieldData
 * @property-read \Nkf\Heroes\Models\Field $field
 */
class FieldsHero extends Model
{
    public $timestamps = false;
    public $table = 'nkf_heroes_field_heroes';

    public $belongsTo = [
        'hero' => Hero::class,
        'field' => Field::class,
    ];

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}