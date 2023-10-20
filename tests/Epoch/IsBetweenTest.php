<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class IsBetweenTest extends TestCase
{
    public function testIsBetweenInvalidDate(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);
        self::assertFalse($e->isBetween('sdkgjsfds', 'jgfkjdfkjdfj'), 'invalid date-string parameter 1 returns false');
        self::assertFalse($e->isBetween($e, 'jgfkjdfkjdfj'), 'invalid date-string parameter 2 returns false');
    }

    public function testIsBetweenYear(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::YEARS;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 6, 6, 7, 8, 9, 10),
                Epoch::from(2011, 6, 6, 7, 8, 9, 10),
                $units
            ),
            'year match'
        );
    }
}
