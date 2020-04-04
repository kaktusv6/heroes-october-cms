<?php declare(strict_types=1);

namespace Nkf\Heroes\Api;

use Exception;
use Throwable;

class ApiException extends Exception
{
    private $errors;

    public function __construct($errors, Throwable $previous = null)
    {
        if (is_string($errors)) {
            $errors = [$errors];
        }
        $this->errors = ['errors' => $errors];
        parent::__construct(json_encode($this->errors), 0, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
