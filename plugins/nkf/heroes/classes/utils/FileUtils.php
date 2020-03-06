<?php declare(strict_types=1);

namespace Nkf\Heroes\Utils;


class FileUtils extends Utils
{
    public static function getContent(string $path): string
    {
        return file_get_contents($path);
    }

    public static function join(...$paths): string
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}
