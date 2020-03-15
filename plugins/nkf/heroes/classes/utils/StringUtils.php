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

    public static function snakeToText(string $value): string
    {
        return ucfirst(str_replace('_', ' ', $value));
    }

    public static function snakeToCamel(string $value): string
    {
        return str_replace(' ', '', ucwords(self::snakeToText($value)));
    }

    public static function strripos(string $haystack, string $needle): bool
    {
        return strripos($haystack, $needle) !== false;
    }
}
