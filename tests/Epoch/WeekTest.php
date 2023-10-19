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
            'Jan 1 2000 should be day 1 of the year'
        );
        self::assertEquals(
            59,
            Epoch::from(2000, 2, 28)->dayOfYear(),
            'Feb 28 2000 should be day 59 of the year'
        );
        self::assertEquals(
            60,
            Epoch::from(2000, 2, 29)->dayOfYear(),
            'Feb 29 2000 should be day 60 of the year'
        );
        self::assertEquals(
            366,
            Epoch::from(2000, 12, 31)->dayOfYear(),
            'Dec 31 2000 should be day 366 of the year'
        );
        self::assertEquals(
            1,
            Epoch::from(2001, 1, 1)->dayOfYear(),
            'Jan 1 2001 should be day 1 of the year'
        );
        self::assertEquals(
            59,
            Epoch::from(2001, 2, 28)->dayOfYear(),
            'Feb 28 2001 should be day 59 of the year'
        );
        self::assertEquals(
            60,
            Epoch::from(2001, 3, 1)->dayOfYear(),
            'Mar 1 2001 should be day 60 of the year'
        );
        self::assertEquals(
            365,
            Epoch::from(2001, 12, 31)->dayOfYear(),
            'Dec 31 2001 should be day 365 of the year'
        );
    }

    public function testWeekInYear(): void
    {
        self::assertSame(
            52,
            Epoch::from(2012, 1, 1)->weekOfYear(),
            'Jan 1 2012 should be iso week 52'
        );
        self::assertSame(
            1,
            Epoch::from(2012, 1, 2)->weekOfYear(),
            'Jan 2 2012 should be iso week 1'
        );
        self::assertSame(
            1,
            Epoch::from(2012, 1, 8)->weekOfYear(),
            'Jan 8 2012 should be iso week 1'
        );
        self::assertSame(
            2,
            Epoch::from(2012, 1, 9)->weekOfYear(),
            'Jan 9 2012 should be iso week 2'
        );
        self::assertSame(
            2,
            Epoch::from(2012, 1, 15)->weekOfYear(),
            'Jan 15 2012 should be iso week 2'
        );
    }
}
