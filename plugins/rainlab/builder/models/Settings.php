<?php namespace RainLab\Builder\Models;

use October\Rain\Database\Model;

/**
 * Builder settings model
 *
 * @package rainlab\builder
 * @author Alexey Bobkov, Samuel Georges
 * @property int $id
 * @property string|null $item
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\RainLab\Builder\Models\Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\RainLab\Builder\Models\Settings whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\RainLab\Builder\Models\Settings whereValue($value)
 * @mixin \Eloquent
 */
class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'rainlab_builder_settings';

    public $settingsFields = 'fields.yaml';

    /**
     * Validation rules
     */
    public $rules = [
        'author_name' => 'required',
        'author_namespace' => ['required', 'regex:/^[a-z]+[a-z0-9]+$/i', 'reserved']
    ];
}
