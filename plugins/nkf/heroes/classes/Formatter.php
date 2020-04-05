<?php declare(strict_types=1);

namespace Nkf\Heroes\Classes;

use Closure;

abstract class Formatter
{
    /** @var Closure $formatter */
    private $formatter;

    public function getFormatter(): Closure
    {
        return $this->formatter;
    }

    public function format($item)
    {
        if ($this->formatter === null) {
            throw new Exception('Nullable formatter function');
        }
        return $this->getFormatter()($item);
    }

    public function setFormatter(callable $formatter)
    {
        $this->formatter = $formatter;
    }

    public function formatList(iterable $items)
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = $this->getFormatter()($item);
        }
        return $result;
    }
}
