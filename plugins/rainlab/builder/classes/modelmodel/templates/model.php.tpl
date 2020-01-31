<?php declare(strict_types=1);

namespace {namespace};

use \October\Rain\Database\Traits\Validation;
use Model;

/**
 * Model
 */
class {classname} extends Model
{
    use Validation;
    {dynamicContents}

    public $table = '{table}';

    public $rules = [];
}
