<?php declare(strict_types=1);

namespace Nkf\Heroes\Utils;

class PasswordUtils extends Utils
{
//     todo generate encode decode methods
//     private $method = 'base64';

    public static function decodePassword(string $code): string
    {
        return base64_decode($code);
    }

    public static function encodePassword(string $password): string
    {
        return base64_encode($password);
    }
}
