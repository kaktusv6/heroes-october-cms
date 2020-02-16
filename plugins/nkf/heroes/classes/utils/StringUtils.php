<?php declare(strict_types=1);

namespace Nkf\Heroes\Utils;

class StringUtils extends Utils
{
    public static function startsWith(string $string, string $prefix) : bool
    {
        if ($string === '' || $prefix === '') {
            return false;
        }
        return mb_strpos($string, $prefix) === 0;
    }
}
