<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Utils;
use PHPUnit\Framework\TestCase;

class DaysInMonthTest extends TestCase
{
    public function testAllExceptFebruary(): void
    {
        $days = [31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        for ($year = 1899; $year < 2100; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                if ($month === 2) {
                    continue;
                }

                self::assertSame($days[$month - 1], Epoch::from($year, $month)->daysInMonth());
                self::assertSame($days[$month - 1], Utils::daysInMonths($year, $month));
            }
        }
    }

    public function testDaysInMonth(): void
    {
        $year = 2012;
        foreach ([31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31] as $index => $days) {
            $firstDay = Epoch::from($year, $index + 1);
            $lastDay = Epoch::from($year, $index + 1, $days);

            self::assertSame(
                $days,
                $firstDay->daysInMonth(),
                $firstDay->format('Y/m/d') . ' should have ' . $days . ' days'
            );
            self::assertSame(
                $days,
                $lastDay->daysInMonth(),
                $lastDay->format('Y/m/d') . ' should have ' . $days . ' days'
            );
        }
    }

    public function testDaysInMonthLeapYear(): void
    {
        self::assertSame(28, Epoch::from(2010, 2)->daysInMonth(), 'Feb 2010 should have 28 days');
        self::assertSame(28, Epoch::from(2100, 2)->daysInMonth(), 'Feb 2100 should have 28 days');
        self::assertSame(29, Epoch::from(2008, 2)->daysInMonth(), 'Feb 2008 should have 29 days');
        self::assertSame(29, Epoch::from(2000, 2)->daysInMonth(), 'Feb 2000 should have 29 days');
    }
}
