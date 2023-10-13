<?php

declare(strict_types=1);

namespace Epoch\Exception;

use Exception;
use Throwable;

use function sprintf;

class DateCreationException extends Exception implements Throwable
{
    private array $creationErrors;

    public function __construct(string $message = "", array $errors = [], int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->creationErrors = [
            ...self::parseErrors($errors, 'warnings'),
            ...self::parseErrors($errors, 'errors')
        ];
    }

    public function getCreationErrors(): array
    {
        return $this->creationErrors;
    }

    private static function parseErrors(array $errors, string $type): array
    {
        $result = [];
        $errors = !empty($errors[$type]) ? $errors[$type] : [];
        foreach ($errors as $column => $message) {
            $result[] = sprintf('%s at column %s', $message, $column);
        }

        return $result;
    }
}
