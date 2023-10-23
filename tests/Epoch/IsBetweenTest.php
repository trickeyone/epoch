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
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2010, 6, 6, 7, 8, 9, 10),
                Epoch::from(2012, 6, 6, 7, 8, 9, 10),
                $units
            ),
            'year is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 6, 6, 7, 8, 9, 10),
                Epoch::from(2013, 6, 6, 7, 8, 9, 10),
                $units
            ),
            'year is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2010, 6, 6, 7, 8, 9, 10),
                Epoch::from(2011, 6, 6, 7, 8, 9, 10),
                $units
            ),
            'year is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same year');
    }

    public function testIsBetweenMonth(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::MONTHS;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 6, 7, 8, 9, 10),
                Epoch::from(2011, 2, 6, 7, 8, 9, 10),
                $units
            ),
            'month match'
        );
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2011, 1, 6, 7, 8, 9, 10),
                Epoch::from(2011, 3, 6, 7, 8, 9, 10),
                $units
            ),
            'month is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 6, 7, 8, 9, 10),
                Epoch::from(2011, 3, 6, 7, 8, 9, 10),
                $units
            ),
            'month is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 11, 6, 7, 8, 9, 10),
                Epoch::from(2011, 2, 6, 7, 8, 9, 10),
                $units
            ),
            'month is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same month');
    }

    public function testIsBetweenDay(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::DAYS;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 7, 8, 9, 10),
                Epoch::from(2011, 2, 2, 7, 8, 9, 10),
                $units
            ),
            'day match'
        );
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2011, 2, 1, 7, 8, 9, 10),
                Epoch::from(2011, 2, 3, 7, 8, 9, 10),
                $units
            ),
            'day is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 7, 8, 9, 10),
                Epoch::from(2011, 2, 4, 7, 8, 9, 10),
                $units
            ),
            'day is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 1, 7, 8, 9, 10),
                Epoch::from(2011, 2, 2, 7, 8, 9, 10),
                $units
            ),
            'day is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same day');
    }

    public function testIsBetweenHour(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::HOURS;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 8, 9, 10),
                Epoch::from(2011, 2, 2, 3, 8, 9, 10),
                $units
            ),
            'hour match'
        );
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 1, 8, 9, 10),
                Epoch::from(2011, 2, 2, 4, 8, 9, 10),
                $units
            ),
            'hour is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 8, 9, 10),
                Epoch::from(2011, 2, 2, 4, 8, 9, 10),
                $units
            ),
            'hour is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 2, 8, 9, 10),
                Epoch::from(2011, 2, 2, 3, 8, 9, 10),
                $units
            ),
            'hour is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same hour');
    }

    public function testIsBetweenMinute(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::MINUTES;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 9, 10),
                Epoch::from(2011, 2, 2, 3, 4, 9, 10),
                $units
            ),
            'minute match'
        );
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 3, 9, 10),
                Epoch::from(2011, 2, 2, 3, 5, 9, 10),
                $units
            ),
            'minute is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 9, 10),
                Epoch::from(2011, 2, 2, 3, 5, 9, 10),
                $units
            ),
            'minute is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 3, 9, 10),
                Epoch::from(2011, 2, 2, 3, 4, 9, 10),
                $units
            ),
            'minute is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same minute');
    }

    public function testIsBetweenSecond(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::SECONDS;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 5, 10),
                Epoch::from(2011, 2, 2, 3, 4, 5, 10),
                $units
            ),
            'seconds match'
        );
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 4, 10),
                Epoch::from(2011, 2, 2, 3, 4, 6, 10),
                $units
            ),
            'seconds is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 4, 10),
                Epoch::from(2011, 2, 2, 3, 4, 5, 10),
                $units
            ),
            'seconds is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 5, 10),
                Epoch::from(2011, 2, 2, 3, 4, 6, 10),
                $units
            ),
            'seconds is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same seconds');
    }

    public function testIsBetweenMillisecond(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6);

        $units = Units::MILLISECONDS;
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 5, 6),
                Epoch::from(2011, 2, 2, 3, 4, 5, 6),
                $units
            ),
            'seconds match'
        );
        self::assertTrue(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 5, 5),
                Epoch::from(2011, 2, 2, 3, 4, 5, 7),
                $units
            ),
            'seconds is between'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 5, 5),
                Epoch::from(2011, 2, 2, 3, 4, 5, 6),
                $units
            ),
            'seconds is earlier'
        );
        self::assertFalse(
            $e->isBetween(
                Epoch::from(2011, 2, 2, 3, 4, 5, 6),
                Epoch::from(2011, 2, 2, 3, 4, 5, 7),
                $units
            ),
            'seconds is later'
        );
        self::assertFalse($e->isBetween($e, $e, $units), 'same epochs are not between the same seconds');
    }
}
