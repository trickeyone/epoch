<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

use function abs;

class GettersAndSettersTest extends TestCase
{
    public function testQuarters(): void
    {
        self::assertEquals(
            1,
            Epoch::from(1985, 2, 4)->quarter(),
            'Feb  4 1985 is Q1'
        );
        self::assertEquals(
            3,
            Epoch::from(2029, 9, 18)->quarter(),
            'Sep 18 2029 is Q3'
        );
        self::assertEquals(
            2,
            Epoch::from(2013, 4, 24)->quarter(),
            'Apr 24 2013 is Q2'
        );
        self::assertEquals(
            1,
            Epoch::from(2015, 3, 5)->quarter(),
            'Mar 5 2015 is Q1'
        );
        self::assertEquals(
            1,
            Epoch::from(1970, 1, 2)->quarter(),
            'Jan 2 1970 is Q1'
        );
        self::assertEquals(
            4,
            Epoch::from(2001, 12, 12)->quarter(),
            'Dec 12 2001 is Q4'
        );
        self::assertEquals(
            1,
            Epoch::from(2000, 1, 2)->quarter(),
            'Jan 2 2000 is Q1'
        );
    }

    public function testQuarterDIff(): void
    {
        self::assertEquals(
            -1,
            Epoch::from(2014, 1, 1)->diff(Epoch::from(2014, 4, 1), Units::QUARTERS),
            'diff -1 quarter'
        );
        self::assertEquals(
            1,
            Epoch::from(2014, 4, 1)->diff(Epoch::from(2014, 1, 1), Units::QUARTERS),
            'diff 1 quarter'
        );
        self::assertEquals(
            1,
            Epoch::from(2014, 5, 1)->diff(Epoch::from(2014, 1, 1), Units::QUARTERS),
            'diff 1 quarter'
        );
        self::assertLessThan(
            0.00001,
            abs(
                4 / 3 - Epoch::from(2014, 5, 1)->diff(Epoch::from(2014, 1, 1), Units::QUARTERS, true)
            ),
            'diff 1 1/3 quarter'
        );
        self::assertEquals(
            4,
            Epoch::from(2015, 1, 1)->diff(Epoch::from(2014, 1, 1), Units::QUARTERS),
            'diff 4 quarters'
        );
    }

    public function testIsoWeekday(): void
    {
        self::assertEquals(
            1,
            Epoch::from(1985, 2, 4)->isoWeekday(),
            'Feb  4 1985 is Monday    -- 1st day'
        );
        self::assertEquals(
            2,
            Epoch::from(2029, 9, 18)->isoWeekday(),
            'Sep 18 2029 is Tuesday   -- 2nd day'
        );
        self::assertEquals(
            3,
            Epoch::from(2013, 4, 24)->isoWeekday(),
            'Apr 24 2013 is Wednesday -- 3rd day'
        );
        self::assertEquals(
            4,
            Epoch::from(2015, 3, 5)->isoWeekday(),
            'Mar  5 2015 is Thursday  -- 4th day'
        );
        self::assertEquals(
            5,
            Epoch::from(1970, 1, 2)->isoWeekday(),
            'Jan  2 1970 is Friday    -- 5th day'
        );
        self::assertEquals(
            6,
            Epoch::from(2001, 5, 12)->isoWeekday(),
            'May 12 2001 is Saturday  -- 6th day'
        );
        self::assertEquals(
            7,
            Epoch::from(2000, 1, 2)->isoWeekday(),
            'Jan  2 2000 is Sunday    -- 7th day'
        );
    }
}
