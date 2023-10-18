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

    public function testQuarterDiff(): void
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

    public function testWeekday(): void
    {
        self::assertSame(
            0,
            Epoch::from(1985, 2, 3)->weekday(),
            'Feb  3 1985 is Sunday    -- 0th day'
        );
        self::assertSame(
            1,
            Epoch::from(2029, 9, 17)->weekday(),
            'Sep 17 2029 is Monday    -- 1st day'
        );
        self::assertSame(
            2,
            Epoch::from(2013, 4, 23)->weekday(),
            'Apr 23 2013 is Tuesday   -- 2nd day'
        );
        self::assertSame(
            3,
            Epoch::from(2015, 3, 4)->weekday(),
            'Mar  4 2015 is Wednesday -- 3nd day'
        );
        self::assertSame(
            4,
            Epoch::from(1970, 1, 1)->weekday(),
            'Jan  1 1970 is Thursday  -- 4th day'
        );
        self::assertSame(
            5,
            Epoch::from(2001, 5, 11)->weekday(),
            'May 11 2001 is Friday    -- 5th day'
        );
        self::assertSame(
            6,
            Epoch::from(2000, 1, 1)->weekday(),
            'Jan  1 2000 is Saturday  -- 6th day'
        );

        $a = Epoch::from(2011, 1, 10);
        self::assertEquals(
            10,
            Epoch::create($a)->setWeekday(1)->day(),
            'set from mon to mon'
        );
        self::assertEquals(
            13,
            Epoch::create($a)->setWeekday(4)->day(),
            'set from thu to thu'
        );
        self::assertEquals(
            16,
            Epoch::create($a)->setWeekday(7)->day(),
            'set from thu to sun'
        );
        self::assertEquals(
            6,
            Epoch::create($a)->setWeekday(-3)->day(),
            'set from mon to last thu'
        );
        self::assertEquals(
            9,
            Epoch::create($a)->setWeekday(0)->day(),
            'set from mon to last sun'
        );
        self::assertEquals(
            17,
            Epoch::create($a)->setWeekday(8)->day(),
            'set from mon to next mon'
        );
        self::assertEquals(
            20,
            Epoch::create($a)->setWeekday(11)->day(),
            'set from mon to next thu'
        );
        self::assertEquals(
            23,
            Epoch::create($a)->setWeekday(14)->day(),
            'set from mon to next sun'
        );

        $a = Epoch::from(2011, 1, 13);
        self::assertEquals(
            10,
            Epoch::create($a)->setWeekday(1)->day(),
            'set from thu to mon'
        );
        self::assertEquals(
            13,
            Epoch::create($a)->setWeekday(4)->day(),
            'set from thu to thu'
        );
        self::assertEquals(
            16,
            Epoch::create($a)->setWeekday(7)->day(),
            'set from thu to sun'
        );
        self::assertEquals(
            3,
            Epoch::create($a)->setWeekday(-6)->day(),
            'set from thu to last mon'
        );
        self::assertEquals(
            6,
            Epoch::create($a)->setWeekday(-3)->day(),
            'set from thu to last thu'
        );
        self::assertEquals(
            9,
            Epoch::create($a)->setWeekday(0)->day(),
            'set from thu to last sun'
        );
        self::assertEquals(
            17,
            Epoch::create($a)->setWeekday(8)->day(),
            'set from thu to next mon'
        );
        self::assertEquals(
            20,
            Epoch::create($a)->setWeekday(11)->day(),
            'set from thu to next thu'
        );
        self::assertEquals(
            23,
            Epoch::create($a)->setWeekday(14)->day(),
            'set from thu to next sun'
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

        $a = Epoch::from(2011, 1, 10);
        self::assertEquals(
            10,
            Epoch::create($a)->setIsoWeekday(1)->day(),
            'set from mon to mon'
        );
        self::assertEquals(
            13,
            Epoch::create($a)->setIsoWeekday(4)->day(),
            'set from thu to thu'
        );
        self::assertEquals(
            16,
            Epoch::create($a)->setIsoWeekday(7)->day(),
            'set from thu to sun'
        );
        self::assertEquals(
            6,
            Epoch::create($a)->setIsoWeekday(-3)->day(),
            'set from mon to last thu'
        );
        self::assertEquals(
            9,
            Epoch::create($a)->setIsoWeekday(0)->day(),
            'set from mon to last sun'
        );
        self::assertEquals(
            17,
            Epoch::create($a)->setIsoWeekday(8)->day(),
            'set from mon to next mon'
        );
        self::assertEquals(
            20,
            Epoch::create($a)->setIsoWeekday(11)->day(),
            'set from mon to next thu'
        );
        self::assertEquals(
            23,
            Epoch::create($a)->setIsoWeekday(14)->day(),
            'set from mon to next sun'
        );

        $a = Epoch::from(2011, 1, 13);
        self::assertEquals(
            10,
            Epoch::create($a)->setIsoWeekday(1)->day(),
            'set from thu to mon'
        );
        self::assertEquals(
            13,
            Epoch::create($a)->setIsoWeekday(4)->day(),
            'set from thu to thu'
        );
        self::assertEquals(
            16,
            Epoch::create($a)->setIsoWeekday(7)->day(),
            'set from thu to sun'
        );
        self::assertEquals(
            3,
            Epoch::create($a)->setIsoWeekday(-6)->day(),
            'set from thu to last mon'
        );
        self::assertEquals(
            6,
            Epoch::create($a)->setIsoWeekday(-3)->day(),
            'set from thu to last thu'
        );
        self::assertEquals(
            9,
            Epoch::create($a)->setIsoWeekday(0)->day(),
            'set from thu to last sun'
        );
        self::assertEquals(
            17,
            Epoch::create($a)->setIsoWeekday(8)->day(),
            'set from thu to next mon'
        );
        self::assertEquals(
            20,
            Epoch::create($a)->setIsoWeekday(11)->day(),
            'set from thu to next thu'
        );
        self::assertEquals(
            23,
            Epoch::create($a)->setIsoWeekday(14)->day(),
            'set from thu to next sun'
        );

        $a = Epoch::from(2011, 1, 16);
        self::assertEquals(
            10,
            Epoch::create($a)->setIsoWeekday(1)->day(),
            'set from sun to mon'
        );
        self::assertEquals(
            13,
            Epoch::create($a)->setIsoWeekday(4)->day(),
            'set from sun to thu'
        );
        self::assertEquals(
            16,
            Epoch::create($a)->setIsoWeekday(7)->day(),
            'set from sun to sun'
        );
        self::assertEquals(
            3,
            Epoch::create($a)->setIsoWeekday(-6)->day(),
            'set from sun to last mon'
        );
        self::assertEquals(
            6,
            Epoch::create($a)->setIsoWeekday(-3)->day(),
            'set from sun to last thu'
        );
        self::assertEquals(
            9,
            Epoch::create($a)->setIsoWeekday(0)->day(),
            'set from sun to last sun'
        );
        self::assertEquals(
            17,
            Epoch::create($a)->setIsoWeekday(8)->day(),
            'set from sun to next mon'
        );
        self::assertEquals(
            20,
            Epoch::create($a)->setIsoWeekday(11)->day(),
            'set from sun to next thu'
        );
        self::assertEquals(
            23,
            Epoch::create($a)->setIsoWeekday(14)->day(),
            'set from sun to next sun'
        );
    }
}
