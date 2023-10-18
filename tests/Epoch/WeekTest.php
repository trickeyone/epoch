<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use PHPUnit\Framework\TestCase;

class WeekTest extends TestCase
{
    public function testDayOfYear(): void
    {
        self::assertEquals(
            1,
            Epoch::from(2000, 1, 1)->dayOfYear(),
            'Jan  1 2000 should be day 1 of the year'
        );
        self::assertEquals(
            59,
            Epoch::from(2000, 2, 28)->dayOfYear(),
            'Feb 28 2000 should be day 59 of the year'
        );
    }
}
