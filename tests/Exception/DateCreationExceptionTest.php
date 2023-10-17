<?php

declare(strict_types=1);

namespace Epoch\Test\Exception;

use Epoch\Exception\DateCreationException;
use PHPUnit\Framework\TestCase;

class DateCreationExceptionTest extends TestCase
{
    public function testParseWarningsAndErrors(): void
    {
        $errors = [
            'warnings' => [
                1 => 'WARNING-1',
                3 => 'WARNING-2',
            ],
            'errors'   => [
                8  => 'ERROR-3',
                12 => 'ERROR-4',
            ]
        ];

        $expectedErrors = [
            'WARNING-1 at column 1',
            'WARNING-2 at column 3',
            'ERROR-3 at column 8',
            'ERROR-4 at column 12',
        ];

        $exception = new DateCreationException('Foo', $errors);

        self::assertEquals($expectedErrors, $exception->getCreationErrors());
    }
}
