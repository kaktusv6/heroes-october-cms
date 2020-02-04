<?php declare(strict_types=1);

namespace Nkf\Heroes\Utils;

class JsonUtils extends Utils
{
    public static function decode(string $json): mixed
    {
        return json_decode($json, true);
    }

    public static function decodeFile(string $pathToFile): mixed
    {
        return self::decode(FileUtils::getContent($pathToFile));
    }
}
