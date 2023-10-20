<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class IsBeforeTest extends TestCase
{
    public function testIsBeforeInvalidDate(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);
        self::assertFalse($e->isBefore('sdkgjsfds'), 'invalid date-string returns false');
    }

    public function testIsBeforeYear(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);

        $units = Units::YEARS;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 6, 6, 7, 8, 9, 10), $units),
            'year match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2013, 6, 6, 7, 8, 9, 10), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 6, 6, 7, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 1, 1, 0, 0, 0, 0), $units),
            'exact start of year'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 12, 31, 23, 59, 59, 999), $units),
            'exact end of year'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 1, 1, 0, 0, 0, 0), $units),
            'start of next year'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 12, 31, 23, 59, 59, 999), $units),
            'end of previous year'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(1980, 12, 31, 23, 59, 59, 999), $units),
            'end of year far before'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }

    public function testIsBeforeMonth(): void
    {
        $e = Epoch::from(2011, 3, 3, 4, 5, 6, 7);

        $units = Units::MONTHS;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 6, 7, 8, 9, 10), $units),
            'month match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 3, 6, 7, 8, 9, 10), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 3, 6, 7, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 6, 6, 7, 8, 9, 10), $units),
            'month is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 2, 6, 7, 8, 9, 10), $units),
            'month is earlier'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 1, 0, 0, 0, 0), $units),
            'exact start of month'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 31, 23, 59, 59, 999), $units),
            'exact end of month'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 1, 0, 0, 0, 0), $units),
            'start of next month'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 2, 27, 23, 59, 59, 999), $units),
            'end of previous month'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 12, 31, 23, 59, 59, 999), $units),
            'later month but earlier year'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }

    public function testIsBeforeDay(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        $units = Units::DAYS;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 7, 8, 9, 10), $units),
            'day match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 4, 2, 7, 8, 9, 10), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 7, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 5, 2, 7, 8, 9, 10), $units),
            'month is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 2, 7, 8, 9, 10), $units),
            'month is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 3, 7, 8, 9, 10), $units),
            'day is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 1, 7, 8, 9, 10), $units),
            'day is earlier'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 0, 0, 0, 0), $units),
            'exact start of day'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 23, 59, 59, 999), $units),
            'exact end of day'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 3, 0, 0, 0, 0), $units),
            'start of next day'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 1, 23, 59, 59, 999), $units),
            'end of previous day'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 10, 0, 0, 0, 0), $units),
            'later day but earlier year'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }

    public function testIsBeforeHour(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        $units = Units::HOURS;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 8, 9, 10), $units),
            'hour match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 4, 2, 3, 8, 9, 10), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 8, 9, 10), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 5, 2, 3, 8, 9, 10), $units),
            'month is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 2, 3, 8, 9, 10), $units),
            'month is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 3, 3, 8, 9, 10), $units),
            'day is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 1, 3, 8, 9, 10), $units),
            'day is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 4, 8, 9, 10), $units),
            'hour is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 2, 8, 9, 10), $units),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 0, 0, 0), $units),
            'exact start of hour'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 59, 59, 999), $units),
            'exact end of hour'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 4, 0, 0, 0), $units),
            'start of next hour'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 2, 59, 59, 999), $units),
            'end of previous hour'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 0, 0, 0), $units),
            'later hour but earlier year'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }

    public function testIsBeforeMinutes(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        $units = Units::MINUTES;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 9, 10), $units),
            'minute match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 4, 2, 3, 4, 9, 10), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 4, 9, 10), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 5, 2, 3, 4, 9, 10), $units),
            'month is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 2, 3, 4, 9, 10), $units),
            'month is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 3, 3, 4, 9, 10), $units),
            'day is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 1, 3, 4, 9, 10), $units),
            'day is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 4, 4, 9, 10), $units),
            'hour is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 2, 4, 9, 10), $units),
            'hour is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 5, 9, 10), $units),
            'minute is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 3, 9, 10), $units),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 0, 0), $units),
            'exact start of minute'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 59, 999), $units),
            'exact end of minute'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 5, 0, 0), $units),
            'start of next minute'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 3, 59, 999), $units),
            'end of previous minute'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 10, 59, 999), $units),
            'later minute but earlier year'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }

    public function testIsBeforeSecond(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        $units = Units::SECONDS;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 5, 10), $units),
            'second match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 4, 2, 3, 4, 5, 10), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 4, 5, 10), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 5, 2, 3, 4, 5, 10), $units),
            'month is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 2, 3, 4, 5, 10), $units),
            'month is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 3, 3, 4, 5, 10), $units),
            'day is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 1, 3, 4, 5, 10), $units),
            'day is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 4, 4, 5, 10), $units),
            'hour is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 2, 4, 5, 10), $units),
            'hour is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 5, 5, 10), $units),
            'minute is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 3, 5, 10), $units),
            'minute is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 6, 10), $units),
            'second is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 4, 10), $units),
            'second is earlier'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 5, 0), $units),
            'exact start of second'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 5, 999), $units),
            'exact end of second'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 6, 0), $units),
            'start of next second'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 4, 999), $units),
            'end of previous second'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 4, 59, 999), $units),
            'later second but earlier year'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }

    public function testIsBeforeMillisecond(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        $units = Units::MILLISECONDS;
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 5, 6), $units),
            'millisecond match'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2012, 4, 2, 3, 4, 5, 6), $units),
            'year is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2010, 4, 2, 3, 4, 5, 6), $units),
            'year is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 5, 2, 3, 4, 5, 6), $units),
            'month is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 3, 2, 3, 4, 5, 6), $units),
            'month is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 3, 3, 4, 5, 6), $units),
            'day is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 1, 3, 4, 5, 6), $units),
            'day is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 4, 4, 5, 6), $units),
            'hour is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 2, 4, 5, 6), $units),
            'hour is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 5, 5, 6), $units),
            'minute is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 3, 5, 6), $units),
            'minute is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 6, 6), $units),
            'second is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 4, 6), $units),
            'second is earlier'
        );
        self::assertTrue(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 6, 7), $units),
            'millisecond is later'
        );
        self::assertFalse(
            $e->isBefore(Epoch::from(2011, 4, 2, 3, 4, 4, 5), $units),
            'millisecond is earlier'
        );
        self::assertFalse($e->isBefore($e, $units), 'same moments are not before the same year');
    }
}
