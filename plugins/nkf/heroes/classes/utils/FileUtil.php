<?php declare(strict_types=1);

namespace Nkf\Heroes\Utils;

class FileUtil extends Util
{
    public static function getContent(string $path): string
    {
        return file_get_contents($path);
    }

    public static function concatPaths(): string
    {
        $path = '';
        foreach (func_get_args() as $param) {
            $path .= '/'.$param;
        }
        return $path;
    }
}
