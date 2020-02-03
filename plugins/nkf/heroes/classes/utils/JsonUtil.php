<?php declare(strict_types=1);

namespace Nkf\Heroes\Utils;

use phpDocumentor\Reflection\Types\Mixed_;

class JsonUtil extends Util
{
    public static function decode(string $json): mixed
    {
        return json_decode($json, true);
    }

    public static function decodeFile(string $pathToFile): mixed
    {
        return self::decode(FileUtil::getContent($pathToFile));
    }
}
