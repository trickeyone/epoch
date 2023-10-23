<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class IsSameOrAfterTest extends TestCase
{
    public function testIsSameOrAfterYear(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::YEARS;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 6, 6, 7, 8, 9, 10), $units),
            'year match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 6, 6, 7, 8, 9, 10), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 6, 6, 7, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 1, 1, 0, 0, 0, 0), $units),
            'exact start of year'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 12, 31, 23, 59, 59, 999), $units),
            'exact end of year'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 1, 1, 0, 0, 0, 0), $units),
            'start of next year'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 12, 31, 23, 59, 59, 999), $units),
            'end of previous year'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same year');
    }

    public function testIsSameOrAfterMonth(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::MONTHS;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 6, 7, 8, 9, 10), $units),
            'month match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 6, 7, 8, 9, 10), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 6, 7, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 4, 6, 7, 8, 9, 10), $units),
            'month is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 2, 6, 7, 8, 9, 10), $units),
            'month is earlier'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 1, 0, 0, 0, 0), $units),
            'exact start of month'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 31, 23, 59, 59, 999), $units),
            'exact end of month'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2011, 4, 1, 0, 0, 0, 0), $units),
            'start of next month'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 2, 27, 23, 59, 59, 999), $units),
            'end of previous month'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same month');
    }

    public function testIsSameOrAfterDay(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::DAYS;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 7, 8, 9, 10), $units),
            'day match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 7, 8, 9, 10), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 7, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 7, 8, 9, 10), $units),
            'month is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 7, 8, 9, 10), $units),
            'month is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 3, 7, 8, 9, 10), $units),
            'day is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 1, 7, 8, 9, 10), $units),
            'day is earlier'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 0, 0, 0, 0), $units),
            'exact start of day'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 23, 59, 59, 999), $units),
            'exact end of day'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2011, 3, 3, 0, 0, 0, 0), $units),
            'start of next day'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 1, 23, 59, 59, 999), $units),
            'end of previous day'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same day');
    }

    public function testIsSameOrAfterHour(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::HOURS;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 8, 9, 10), $units),
            'hour match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 8, 9, 10), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 8, 9, 10), $units),
            'month is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 8, 9, 10), $units),
            'month is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 3, 3, 8, 9, 10), $units),
            'day is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 1, 3, 8, 9, 10), $units),
            'day is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 4, 8, 9, 10), $units),
            'hour is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 2, 8, 9, 10), $units),
            'hour is earlier'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 0, 0, 0), $units),
            'exact start of hour'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 59, 59, 999), $units),
            'exact end of hour'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 4, 0, 0, 0), $units),
            'start of next hour'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 2, 59, 59, 999), $units),
            'end of previous hour'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same hour');
    }

    public function testIsSameOrAfterMinute(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::MINUTES;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 9, 10), $units),
            'minute match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 9, 10), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 9, 10), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 9, 10), $units),
            'month is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 9, 10), $units),
            'month is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 3, 3, 4, 9, 10), $units),
            'day is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 1, 3, 4, 9, 10), $units),
            'day is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 4, 4, 9, 10), $units),
            'hour is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 2, 4, 9, 10), $units),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 5, 9, 10), $units),
            'minute is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 3, 9, 10), $units),
            'minute is earlier'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 0, 0), $units),
            'exact start of minute'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 59, 999), $units),
            'exact end of minute'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 5, 0, 0), $units),
            'start of next minute'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 3, 59, 999), $units),
            'end of previous minute'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same minute');
    }

    public function testIsSameOrAfterSecond(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::SECONDS;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 5, 10), $units),
            'second match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 5, 10), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 5, 10), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 5, 10), $units),
            'month is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 5, 10), $units),
            'month is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 3, 3, 4, 5, 10), $units),
            'day is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 1, 3, 4, 5, 10), $units),
            'day is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 4, 4, 5, 10), $units),
            'hour is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 2, 4, 5, 10), $units),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 5, 5, 10), $units),
            'minute is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 3, 5, 10), $units),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 6, 10), $units),
            'second is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 4, 10), $units),
            'second is earlier'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 5, 0), $units),
            'exact start of second'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 5, 999), $units),
            'exact end of second'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 6, 0), $units),
            'start of next second'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 4, 999), $units),
            'end of previous second'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same second');
    }

    public function testIsSameOrAfterMillisecond(): void
    {
        $e = Epoch::from(2011, 3, 2, 3, 4, 5, 6);

        $units = Units::MILLISECONDS;
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2011, 3, 2, 3, 4, 5, 6), $units),
            'millisecond match'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 5, 6), $units),
            'year is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 5, 6), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 5, 6), $units),
            'month is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 5, 6), $units),
            'month is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 3, 3, 4, 5, 6), $units),
            'day is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 1, 3, 4, 5, 6), $units),
            'day is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 4, 4, 5, 6), $units),
            'hour is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 2, 4, 5, 6), $units),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 5, 5, 6), $units),
            'minute is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 3, 5, 6), $units),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 6, 6), $units),
            'second is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 4, 6), $units),
            'second is earlier'
        );
        self::assertFalse(
            $e->isSameOrAfter(Epoch::from(2012, 3, 2, 3, 4, 5, 7), $units),
            'millisecond is later'
        );
        self::assertTrue(
            $e->isSameOrAfter(Epoch::from(2010, 3, 2, 3, 4, 5, 5), $units),
            'millisecond is earlier'
        );
        self::assertTrue($e->isSame($e, $units), 'same epochs are in the same millisecond');
    }
}
