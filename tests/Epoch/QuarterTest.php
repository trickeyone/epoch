<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

use function abs;

class QuarterTest extends TestCase
{
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

    public function testGetQuarter(): void
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

    public function testSetQuarter(): void
    {
        $e = Epoch::from(2014, 5, 11);
        self::assertEquals(
            5,
            $e->setQuarter(2)->month(),
            'set same quarter'
        );
        self::assertEquals(
            8,
            $e->setQuarter(3)->month(),
            'set 3rd quarter'
        );
        self::assertEquals(
            2,
            $e->setQuarter(1)->month(),
            'set 1st quarter'
        );
        self::assertEquals(
            11,
            $e->setQuarter(4)->month(),
            'set 4th quarter'
        );
    }
}
