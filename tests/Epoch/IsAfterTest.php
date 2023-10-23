<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class IsAfterTest extends TestCase
{
    public function testIsAfterInvalidDate(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);
        self::assertFalse($e->isAfter('sdfsdhdfh'), 'invalid date-string returns false');
    }

    public function testIsAfterWithDefaultUnits(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);
        $c = Epoch::create($e);

        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 4, 2, 3, 5, 5, 10)),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 2, 3, 5, 5, 10)),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 5, 2, 3, 5, 5, 10)),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 3, 2, 3, 5, 5, 10)),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 3, 5, 5, 10)),
            'day is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 3, 5, 5, 10)),
            'day is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 4, 5, 5, 10)),
            'hour is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 2, 5, 5, 10)),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 5, 5, 10)),
            'minute is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 3, 5, 10)),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 6, 10)),
            'seconds is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 4, 10)),
            'seconds is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 11)),
            'milliseconds is later'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 10)),
            'milliseconds is same'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 9)),
            'milliseconds is earlier'
        );
        self::assertFalse($e->isAfter($e), 'not after self');
        self::assertSame($e->value(), $c->value(), 'isAfter second should not change');
    }

    public function testIsAfterYear(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 6, 6, 7, 8, 9, 10), Units::YEARS),
            'year match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 6, 6, 7, 8, 9, 10), Units::YEARS),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 6, 6, 7, 8, 9, 10), Units::YEARS),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 1, 1, 0, 0, 0, 0), Units::YEARS),
            'exact start of year'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 12, 31, 23, 59, 59, 999), Units::YEARS),
            'exact end of year'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 1, 1, 0, 0, 0, 0), Units::YEARS),
            'start of next year'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 12, 31, 23, 59, 59, 999), Units::YEARS),
            'end of previous year'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(1980, 12, 31, 23, 59, 59, 999), Units::YEARS),
            'end of year far before'
        );
        self::assertFalse($e->isAfter($e, Units::YEARS), 'same epochs are not after the same year');
    }

    public function testIsAfterMonth(): void
    {
        $e = Epoch::from(2011, 3, 3, 4, 5, 6, 7);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 3, 6, 7, 8, 9, 10), Units::MONTHS),
            'month match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 3, 6, 7, 8, 9, 10), Units::MONTHS),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 3, 6, 7, 8, 9, 10), Units::MONTHS),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 6, 6, 7, 8, 9, 10), Units::MONTHS),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 2, 6, 7, 8, 9, 10), Units::MONTHS),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 3, 1, 0, 0, 0, 0), Units::MONTHS),
            'exact start of month'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 3, 31, 23, 59, 59, 999), Units::MONTHS),
            'exact end of month'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 1, 0, 0, 0, 0), Units::MONTHS),
            'start of next month'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 2, 27, 23, 59, 59, 999), Units::MONTHS),
            'end of previous month'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 12, 31, 23, 59, 59, 999), Units::MONTHS),
            'later month but earlier year'
        );
        self::assertFalse($e->isAfter($e, Units::MONTHS), 'same epochs are not after the same month');
    }

    public function testIsAfterDay(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 7, 8, 9, 10), Units::DAYS),
            'day match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 4, 2, 7, 8, 9, 10), Units::DAYS),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 2, 7, 8, 9, 10), Units::DAYS),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 5, 2, 7, 8, 9, 10), Units::DAYS),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 3, 2, 7, 8, 9, 10), Units::DAYS),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 7, 8, 9, 10), Units::DAYS),
            'day is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 7, 8, 9, 10), Units::DAYS),
            'day is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 0, 0, 0, 0), Units::DAYS),
            'exact start of day'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 23, 59, 59, 999), Units::DAYS),
            'exact end of day'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 0, 0, 0, 0), Units::DAYS),
            'start of next day'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 23, 59, 59, 999), Units::DAYS),
            'end of previous day'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 10, 0, 0, 0, 0), Units::DAYS),
            'later day but earlier year'
        );
        self::assertFalse($e->isAfter($e, Units::DAYS), 'same epochs are not after the same day');
    }

    public function testIsAfterHour(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 9, 10), Units::HOURS),
            'hour match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 4, 2, 3, 4, 9, 10), Units::HOURS),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 2, 3, 4, 9, 10), Units::HOURS),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 5, 2, 3, 4, 9, 10), Units::HOURS),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 3, 2, 3, 4, 9, 10), Units::HOURS),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 3, 4, 9, 10), Units::HOURS),
            'day is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 3, 4, 9, 10), Units::HOURS),
            'day is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 4, 8, 9, 10), Units::HOURS),
            'hour is later'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 9, 10), Units::HOURS),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 0, 0, 0), Units::HOURS),
            'exact start of hour'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 59, 59, 999), Units::HOURS),
            'exact end of hour'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 4, 0, 0, 0), Units::HOURS),
            'start of next hour'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 2, 59, 59, 999), Units::HOURS),
            'end of previous hour'
        );
        self::assertFalse($e->isAfter($e, Units::HOURS), 'same epochs are not after the same day');
    }

    public function testIsAfterMinute(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 6);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 9, 10), Units::MINUTES),
            'minute match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 4, 2, 3, 4, 9, 10), Units::MINUTES),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 2, 3, 4, 9, 10), Units::MINUTES),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 5, 2, 3, 4, 9, 10), Units::MINUTES),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 3, 2, 3, 4, 9, 10), Units::MINUTES),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 3, 4, 9, 10), Units::MINUTES),
            'day is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 3, 4, 9, 10), Units::MINUTES),
            'day is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 4, 4, 9, 10), Units::MINUTES),
            'hour is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 2, 4, 9, 10), Units::MINUTES),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 5, 9, 10), Units::MINUTES),
            'minute is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 3, 9, 10), Units::MINUTES),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 0, 0), Units::MINUTES),
            'exact start of minute'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 59, 999), Units::MINUTES),
            'exact end of minute'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 5, 0, 0), Units::MINUTES),
            'start of next minute'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 3, 59, 999), Units::MINUTES),
            'end of previous minute'
        );
        self::assertFalse($e->isAfter($e, Units::MINUTES), 'same epochs are not after the same day');
    }

    public function testIsAfterSecond(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 10), Units::SECONDS),
            'seconds match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 4, 2, 3, 4, 5, 10), Units::SECONDS),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 2, 3, 4, 5, 10), Units::SECONDS),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 5, 2, 3, 4, 5, 10), Units::SECONDS),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 3, 2, 3, 4, 5, 10), Units::SECONDS),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 3, 4, 5, 10), Units::SECONDS),
            'day is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 3, 4, 5, 10), Units::SECONDS),
            'day is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 4, 4, 5, 10), Units::SECONDS),
            'hour is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 2, 4, 5, 10), Units::SECONDS),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 5, 5, 10), Units::SECONDS),
            'minute is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 3, 5, 10), Units::SECONDS),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 6, 10), Units::SECONDS),
            'second is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 4, 10), Units::SECONDS),
            'second is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 0), Units::SECONDS),
            'exact start of second'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 999), Units::SECONDS),
            'exact end of second'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 6, 0), Units::SECONDS),
            'start of next second'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 4, 999), Units::SECONDS),
            'end of previous second'
        );
        self::assertFalse($e->isAfter($e, Units::SECONDS), 'same epochs are not after the same day');
    }

    public function testIsAfterMillisecond(): void
    {
        $e = Epoch::from(2011, 4, 2, 3, 4, 5, 10);

        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 10), Units::MILLISECONDS),
            'milliseconds match'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2012, 4, 2, 3, 4, 5, 10), Units::MILLISECONDS),
            'year is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2010, 4, 2, 3, 4, 5, 10), Units::MILLISECONDS),
            'year is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 5, 2, 3, 4, 5, 10), Units::MILLISECONDS),
            'month is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 3, 2, 3, 4, 5, 10), Units::MILLISECONDS),
            'month is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 3, 3, 4, 5, 10), Units::MILLISECONDS),
            'day is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 1, 3, 4, 5, 10), Units::MILLISECONDS),
            'day is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 4, 4, 5, 10), Units::MILLISECONDS),
            'hour is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 2, 4, 5, 10), Units::MILLISECONDS),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 5, 5, 10), Units::MILLISECONDS),
            'minute is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 3, 5, 10), Units::MILLISECONDS),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 6, 10), Units::MILLISECONDS),
            'second is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 4, 10), Units::MILLISECONDS),
            'second is earlier'
        );
        self::assertFalse(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 11), Units::MILLISECONDS),
            'millisecond is later'
        );
        self::assertTrue(
            $e->isAfter(Epoch::from(2011, 4, 2, 3, 4, 5, 9), Units::MILLISECONDS),
            'millisecond is earlier'
        );
        self::assertFalse($e->isAfter($e, Units::MILLISECONDS), 'same epochs are not after the same day');
    }
}
