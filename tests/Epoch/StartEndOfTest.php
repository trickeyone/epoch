<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class StartEndOfTest extends TestCase
{
    public function testStartOfYear(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6)->startOf(Units::YEARS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(1, $e->month(), 'strip out the month');
        self::assertEquals(1, $e->day(), 'strip out the day');
        self::assertEquals(0, $e->hours(), 'strip out the hours');
        self::assertEquals(0, $e->minutes(), 'strip out the minutes');
        self::assertEquals(0, $e->seconds(), 'strip out the seconds');
        self::assertEquals(0, $e->milliseconds(), 'strip out the milliseconds');
    }

    public function testEndOfYear(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6)->endOf(Units::YEARS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(12, $e->month(), 'set the month');
        self::assertEquals(31, $e->day(), 'set the day');
        self::assertEquals(23, $e->hours(), 'set the hours');
        self::assertEquals(59, $e->minutes(), 'set the minutes');
        self::assertEquals(59, $e->seconds(), 'set the seconds');
        self::assertEquals(999, $e->milliseconds(), 'set the milliseconds');
    }

    public function testStartOfQuarter(): void
    {
        $e = Epoch::from(2011, 5, 2, 3, 4, 5, 6)->startOf(Units::QUARTERS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(2, $e->quarter(), 'keep the quarter');
        self::assertEquals(4, $e->month(), 'strip out the month');
        self::assertEquals(1, $e->day(), 'strip out the day');
        self::assertEquals(0, $e->hours(), 'strip out the hours');
        self::assertEquals(0, $e->minutes(), 'strip out the minutes');
        self::assertEquals(0, $e->seconds(), 'strip out the seconds');
        self::assertEquals(0, $e->milliseconds(), 'strip out the milliseconds');
    }

    public function testEndOfQuarter(): void
    {
        $e = Epoch::from(2011, 5, 2, 3, 4, 5, 6)->endOf(Units::QUARTERS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(2, $e->quarter(), 'keep the quarter');
        self::assertEquals(6, $e->month(), 'set the month');
        self::assertEquals(30, $e->day(), 'set the day');
        self::assertEquals(23, $e->hours(), 'set the hours');
        self::assertEquals(59, $e->minutes(), 'set the minutes');
        self::assertEquals(59, $e->seconds(), 'set the seconds');
        self::assertEquals(999, $e->milliseconds(), 'set the milliseconds');
    }

    public function testStartOfMonth(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6)->startOf(Units::MONTHS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(2, $e->month(), 'keep month');
        self::assertEquals(1, $e->day(), 'strip out the day');
        self::assertEquals(0, $e->hours(), 'strip out the hours');
        self::assertEquals(0, $e->minutes(), 'strip out the minutes');
        self::assertEquals(0, $e->seconds(), 'strip out the seconds');
        self::assertEquals(0, $e->milliseconds(), 'strip out the milliseconds');

        $e = Epoch::from(2011, 1, 2, 3, 4, 5, 6)->startOf(Units::MONTHS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(1, $e->month(), 'keep month');
        self::assertEquals(1, $e->day(), 'strip out the day');
        self::assertEquals(0, $e->hours(), 'strip out the hours');
        self::assertEquals(0, $e->minutes(), 'strip out the minutes');
        self::assertEquals(0, $e->seconds(), 'strip out the seconds');
        self::assertEquals(0, $e->milliseconds(), 'strip out the milliseconds');
    }

    public function testEndOfMonth(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6)->endOf(Units::MONTHS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(2, $e->month(), 'keep month');
        self::assertEquals(28, $e->day(), 'set the day');
        self::assertEquals(23, $e->hours(), 'set the hours');
        self::assertEquals(59, $e->minutes(), 'set the minutes');
        self::assertEquals(59, $e->seconds(), 'set the seconds');
        self::assertEquals(999, $e->milliseconds(), 'set the milliseconds');

        $e = Epoch::from(2011, 12, 2, 3, 4, 5, 6)->endOf(Units::MONTHS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(12, $e->month(), 'keep month');
        self::assertEquals(31, $e->day(), 'set the day');
        self::assertEquals(23, $e->hours(), 'set the hours');
        self::assertEquals(59, $e->minutes(), 'set the minutes');
        self::assertEquals(59, $e->seconds(), 'set the seconds');
        self::assertEquals(999, $e->milliseconds(), 'set the milliseconds');
    }
    public function testStartOfWeek(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6)->startOf(Units::WEEKS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(1, $e->month(), 'rolls back to January');
        self::assertEquals(0, $e->weekday(), 'set day of week');
        self::assertEquals(30, $e->day(), 'strip out the day');
        self::assertEquals(0, $e->hours(), 'strip out the hours');
        self::assertEquals(0, $e->minutes(), 'strip out the minutes');
        self::assertEquals(0, $e->seconds(), 'strip out the seconds');
        self::assertEquals(0, $e->milliseconds(), 'strip out the milliseconds');

        $e = Epoch::from(2011, 1, 1, 3, 4, 5, 6)->startOf(Units::WEEKS);
        self::assertEquals(2010, $e->year(), 'roll back to 2010');
        self::assertEquals(12, $e->month(), 'rolls back to December');
        self::assertEquals(26, $e->day(), 'strip out the day');
        self::assertEquals(0, $e->hours(), 'strip out the hours');
        self::assertEquals(0, $e->minutes(), 'strip out the minutes');
        self::assertEquals(0, $e->seconds(), 'strip out the seconds');
        self::assertEquals(0, $e->milliseconds(), 'strip out the milliseconds');
    }

    public function testEndOfWeek(): void
    {
        $e = Epoch::from(2011, 2, 2, 3, 4, 5, 6)->endOf(Units::WEEKS);
        self::assertEquals(2011, $e->year(), 'keep the year');
        self::assertEquals(2, $e->month(), 'keep month');
        self::assertEquals(5, $e->day(), 'set the end of week');
        self::assertEquals(23, $e->hours(), 'set the hours');
        self::assertEquals(59, $e->minutes(), 'set the minutes');
        self::assertEquals(59, $e->seconds(), 'set the seconds');
        self::assertEquals(999, $e->milliseconds(), 'set the milliseconds');

        $e = Epoch::from(2010, 12, 26, 3, 4, 5, 6)->endOf(Units::WEEKS);
        self::assertEquals(2011, $e->year(), 'move year forward to 2011');
        self::assertEquals(1, $e->month(), 'keep month');
        self::assertEquals(1, $e->day(), 'set the end of week');
        self::assertEquals(23, $e->hours(), 'set the hours');
        self::assertEquals(59, $e->minutes(), 'set the minutes');
        self::assertEquals(59, $e->seconds(), 'set the seconds');
        self::assertEquals(999, $e->milliseconds(), 'set the milliseconds');
    }
}
