<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    public function testSetYearForLeapYear(): void
    {
        self::assertSame(
            28,
            Epoch::from(2008, 2, 29)->setYear(2001)->day(),
            'Feb 29 2008 - from leap year to non-leap year'
        );
        self::assertSame(
            29,
            Epoch::from(2008, 2, 29)->setYear(2004)->day(),
            'Feb 29 2008 - from leap year to leap year'
        );
    }

    /** Some examples taken from @link(https://en.wikipedia.org/wiki/ISO_week) */
    public function testIsoWeekYear(): void
    {
        self::assertSame(2004, Epoch::from(2005, 1, 1)->isoWeekYear());
        self::assertSame(2004, Epoch::from(2005, 1, 2)->isoWeekYear());
        self::assertSame(2005, Epoch::from(2005, 1, 3)->isoWeekYear());
        self::assertSame(2005, Epoch::from(2005, 11, 31)->isoWeekYear());
        self::assertSame(2005, Epoch::from(2006, 1, 1)->isoWeekYear());
        self::assertSame(2006, Epoch::from(2006, 1, 2)->isoWeekYear());
    }

    public function testLeapYear(): void
    {
        self::assertFalse(Epoch::from(2010, 1, 1)->isLeapYear());
        self::assertFalse(Epoch::from(2100, 1, 1)->isLeapYear());
        self::assertTrue(Epoch::from(2008, 1, 1)->isLeapYear());
        self::assertTrue(Epoch::from(2000, 1, 1)->isLeapYear());
    }

    #[DataProvider('leapYearCases')]
    /** @dataProvider leapYearCases */
    public function testIsLeapYear(int $year, bool $expected, string $message): void
    {
        self::assertSame($expected, Epoch::from($year)->isLeapYear(), $message);
    }

    public static function leapYearCases(): Generator
    {
        yield [1, false, '1 was not a leap year'];
        yield [4, true, '4 was a leap year'];
        yield [100, false, '100 was not a leap year'];
        yield [400, true, '400 was a leap year'];
        yield [1700, false, '1700 was a leap year in the Julian calendar, but not Gregorian'];
        yield [1900, false, '1900 was not a leap year, but this is a well known Microsoft Excel bug'];
        yield [1904, true, '1904 was a leap year'];
        yield [2000, true, '2000 was a leap year'];
        yield [2008, true, '2008 was a leap year'];
        yield [2010, false, '2010 was not a leap year'];
    }
}
