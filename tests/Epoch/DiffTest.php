<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use DateTime;
use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

use function abs;
use function chr;
use function sprintf;

class DiffTest extends TestCase
{
    public function testDiffOneHour(): void
    {
        $now = Epoch::create();
        $oneHour = clone $now;
        $oneHour->setHours($now->hours() + 1);

        self::assertEquals(60 * 60 * 1000, $oneHour->diff($now), '1 hour from now = 3600000');
    }

    public function testDiffNegative(): void
    {
        self::assertEquals(
            -1,
            Epoch::from(2010)
                ->diff(Epoch::from(2011), Units::YEARS),
            'years diff'
        );
        self::assertEquals(
            -2,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 3), Units::MONTHS),
            'months diff'
        );
        self::assertEquals(
            0,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 7), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            -1,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 8), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            -2,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 21), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            -3,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 22), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            -3,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 4), Units::DAYS),
            'days diff'
        );
        self::assertEquals(
            -4,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 1, 4), Units::HOURS),
            'hours diff'
        );
        self::assertEquals(
            -5,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 1, 0, 5), Units::MINUTES),
            'minutes diff'
        );
        self::assertEquals(
            -6,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 1, 0, 0, 6), Units::SECONDS),
            'seconds diff'
        );
    }

    public function testDiffPositive(): void
    {
        self::assertEquals(
            1,
            Epoch::from(2011)
                ->diff(Epoch::from(2010), Units::YEARS),
            'years diff'
        );
        self::assertEquals(
            1,
            Epoch::from(2010, 4)
                ->diff(Epoch::from(2010), Units::QUARTERS),
            'quarters diff'
        );
        self::assertEquals(
            2,
            Epoch::from(2010, 3)
                ->diff(Epoch::from(2010), Units::MONTHS),
            'months diff'
        );
        self::assertEquals(
            3,
            Epoch::from(2010, 1, 4)
                ->diff(Epoch::from(2010), Units::DAYS),
            'days diff'
        );
        self::assertEquals(
            0,
            Epoch::from(2010, 1, 7)
                ->diff(Epoch::from(2010), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            1,
            Epoch::from(2010, 1, 8)
                ->diff(Epoch::from(2010), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            2,
            Epoch::from(2010, 1, 21)
                ->diff(Epoch::from(2010), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            3,
            Epoch::from(2010, 1, 22)
                ->diff(Epoch::from(2010), Units::WEEKS),
            'weeks diff'
        );
        self::assertEquals(
            4,
            Epoch::from(2010, 1, 1, 4)
                ->diff(Epoch::from(2010), Units::HOURS),
            'hours diff'
        );
        self::assertEquals(
            5,
            Epoch::from(2010, 1, 1, 0, 5)
                ->diff(Epoch::from(2010), Units::MINUTES),
            'minutes diff'
        );
        self::assertEquals(
            6,
            Epoch::from(2010, 1, 1, 0, 0, 6)
                ->diff(Epoch::from(2010), Units::SECONDS),
            'seconds diff'
        );
    }

    public function testDiffEndOfMonth(): void
    {
        self::assertEquals(
            1,
            Epoch::from(2016, 2, 29)
                ->diff(Epoch::from(2016, 1, 30), Units::MONTHS),
            'Feb 29 to Jan 30 should be 1 month'
        );
        self::assertEquals(
            1,
            Epoch::from(2016, 2, 29)
                ->diff(Epoch::from(2016, 1, 31), Units::MONTHS),
            'Feb 29 to Jan 31 should be 1 month'
        );
        self::assertEquals(
            1,
            Epoch::from(2016, 5, 31)
                ->add(1, Units::MONTHS)
                ->diff(Epoch::from(2016, 5, 31), Units::MONTHS),
            '(May 31 plus 1 month) to May 31 should be 1 month diff'
        );
    }

    public function testEndOfMonthWithTimeBehind(): void
    {
        self::assertEquals(
            1,
            Epoch::from(2017, 3, 31)
                ->diff(Epoch::from(2017, 2, 28), Units::MONTHS),
            'Feb 28 to March 31 should be 1 month'
        );
        self::assertEquals(
            -1,
            Epoch::from(2017, 2, 28)
                ->diff(Epoch::from(2017, 3, 31), Units::MONTHS),
            'Feb 28 to March 31 should be 1 month'
        );
    }

    public function testDiffAcrossDST(): void
    {
        [$a, $diff] = self::getDSTForYear(2012);
        $b = $a->clone()->add(12, Units::HOURS);

        self::assertEquals(
            12 * 60 * 60 * 1000,
            $b->diff($a, Units::MILLISECONDS, true),
            'ms diff across DST'
        );
        self::assertEquals(
            12 * 60 * 60,
            $b->diff($a, Units::SECONDS, true),
            'second diff across DST'
        );
        self::assertEquals(
            12 * 60,
            $b->diff($a, Units::MINUTES, true),
            'minute diff across DST'
        );
        self::assertEquals(
            12,
            $b->diff($a, Units::HOURS, true),
            'hour diff across DST'
        );
        self::assertEquals(
            (12 - $diff) / 24,
            $b->diff($a, Units::DAYS, true),
            'day diff across DST'
        );
        self::assertEquals(
            (12 - $diff) / 24 / 7,
            $b->diff($a, Units::WEEKS, true),
            'week diff across DST'
        );
        self::assertGreaterThan(
            0.95 / (2 * 31),
            $b->diff($a, Units::MONTHS, true),
            'month diff across DST, lower bound'
        );
        self::assertLessThan(
            1.05 / (2 * 28),
            $b->diff($a, Units::MONTHS, true),
            'month diff across DST, upper bound'
        );
        self::assertGreaterThan(
            0.95 / (2 * 31 * 12),
            $b->diff($a, Units::YEARS, true),
            'year diff across DST, lower bound'
        );
        self::assertLessThan(
            1.05 / (2 * 28 * 12),
            $b->diff($a, Units::YEARS, true),
            'year diff across DST, upper bound'
        );

        $b = $a->clone()->add(12 + $diff, Units::HOURS);
        self::assertEquals(
            (12 + $diff) * 60 * 60 * 1000,
            $b->diff($a, Units::MILLISECONDS, true),
            'ms diff across DST'
        );
        self::assertEquals(
            (12 + $diff) * 60 * 60,
            $b->diff($a, Units::SECONDS, true),
            'second diff across DST'
        );
        self::assertEquals(
            (12 + $diff) * 60,
            $b->diff($a, Units::MINUTES, true),
            'minute diff across DST'
        );
        self::assertEquals(
            12 + $diff,
            $b->diff($a, Units::HOURS, true),
            'hour diff across DST'
        );
        self::assertEquals(
            12 / 24,
            $b->diff($a, Units::DAYS, true),
            'day diff across DST'
        );
        self::assertEquals(
            12 / 24 / 7,
            $b->diff($a, Units::WEEKS, true),
            'week diff across DST'
        );
        self::assertGreaterThan(
            0.95 / (2 * 31),
            $b->diff($a, Units::MONTHS, true),
            'month diff across DST, lower bound'
        );
        self::assertLessThan(
            1.05 / (2 * 28),
            $b->diff($a, Units::MONTHS, true),
            'month diff across DST, upper bound'
        );
        self::assertGreaterThan(
            0.95 / (2 * 31 * 12),
            $b->diff($a, Units::YEARS, true),
            'year diff across DST, lower bound'
        );
        self::assertLessThan(
            1.05 / (2 * 28 * 12),
            $b->diff($a, Units::YEARS, true),
            'year diff across DST, upper bound'
        );
    }

    public function testDiffFloored(): void
    {
        self::assertEquals(
            0,
            Epoch::from(2010, 1, 1, 23)->diff(Epoch::from(2010), Units::DAYS),
            '23 hours = 0 days'
        );
        self::assertEquals(
            0,
            Epoch::from(2010, 1, 1, 23, 59)->diff(Epoch::from(2010), Units::DAYS),
            '23:59 hours = 0 days'
        );
        self::assertEquals(
            1,
            Epoch::from(2010, 1, 1, 24)->diff(Epoch::from(2010), Units::DAYS),
            '24 hours = 1 day'
        );
        self::assertEquals(
            0,
            Epoch::from(2010, 1, 2)->diff(Epoch::from(2011, 1, 1), Units::YEARS),
            'year rounded down'
        );
        self::assertEquals(
            0,
            Epoch::from(2011, 1, 1)->diff(Epoch::from(2010, 1, 2), Units::YEARS),
            'year rounded down'
        );
        self::assertEquals(
            -1,
            Epoch::from(2010, 1, 2)->diff(Epoch::from(2011, 1, 2), Units::YEARS),
            'year rounded down'
        );
        self::assertEquals(
            1,
            Epoch::from(2011, 1, 2)->diff(Epoch::from(2010, 1, 2), Units::YEARS),
            'year rounded down'
        );
    }

    public function testMonthDiff(): void
    {
        self::assertEquals(
            -1.0,
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2012, 2, 1), Units::MONTHS, true),
            'Jan 1 to Feb 1 should be 1 month'
        );
        self::assertEpochEquals(
            -0.5 / 31,
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2012, 1, 1, 12), Units::MONTHS, true),
            'Jan 1 to Jan 1 noon should be 0.5 / 31 months'
        );
        self::assertEquals(
            -1.0,
            Epoch::from(2012, 1, 15)->diff(Epoch::from(2012, 2, 15), Units::MONTHS, true),
            'Jan 15 to Feb 15 should be 1 month'
        );
        self::assertEquals(
            -1.0,
            Epoch::from(2012, 1, 28)->diff(Epoch::from(2012, 2, 28), Units::MONTHS, true),
            'Jan 28 to Feb 28 should be 1 month'
        );
        self::assertEquals(
            -1.0,
            Epoch::from(2012, 1, 31)->diff(Epoch::from(2012, 2, 29), Units::MONTHS),
            'Jan 31 to Feb 29 should be 1 month'
        );
        self::assertEpochEquals(
            -1.0,
            Epoch::from(2012, 1, 31)->diff(Epoch::from(2012, 3, 1), Units::MONTHS),
            'Jan 31 to Mar 1 should be more than 1 month'
        );
        self::assertGreaterThan(
            -30 / 28,
            Epoch::from(2012, 1, 31)->diff(Epoch::from(2012, 3, 1), Units::MONTHS, true),
            'Jan 31 to Mar 1 should be less than 1 month and 1 day'
        );
        self::assertEpochEquals(
            -(30 / 31),
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2012, 1, 31), Units::MONTHS, true),
            'Jan 1 to Jan 31 should be 30 / 31 months'
        );
        self::assertGreaterThan(
            0,
            Epoch::from(2014, 2, 1)->diff(Epoch::from(2014, 1, 31), Units::MONTHS, true),
            'Jan 31 to Feb 1 is positive'
        );
    }

    public function testExactMonthDiff(): void
    {
        for ($m1 = 1; $m1 <= 12; $m1++) {
            for ($m2 = $m1; $m2 < 12; $m2++) {
                self::assertEquals(
                    $m2 - $m1,
                    Epoch::from(2013, $m2, 15)->diff(
                        Epoch::from(2013, $m1, 15),
                        Units::MONTHS,
                        true
                    ),
                    sprintf("month diff from 2013-%d-15 to 2013-%d-15", $m1, $m2)
                );
            }
        }
    }

    public function testYearDiff(): void
    {
        self::assertEpochEquals(
            -1,
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2013, 1, 1), Units::YEARS, true),
            'Jan 1 2012 to Jan 1 2013 should be 1 year'
        );
        self::assertEpochEquals(
            -1,
            Epoch::from(2012, 2, 28)->diff(Epoch::from(2013, 2, 28), Units::YEARS, true),
            'Feb 28 2012 to Feb 28 2013 should be 1 year'
        );
        self::assertEpochEquals(
            -1,
            Epoch::from(2012, 3, 1)->diff(Epoch::from(2013, 3, 1), Units::YEARS, true),
            'Mar 1 2012 to Mar 1 2013 should be 1 year'
        );
        self::assertEpochEquals(
            -1,
            Epoch::from(2012, 12, 1)->diff(Epoch::from(2013, 12, 1), Units::YEARS, true),
            'Dec 1 2012 to Dec 1 2013 should be 1 year'
        );
        self::assertEpochEquals(
            -1,
            Epoch::from(2012, 12, 31)->diff(Epoch::from(2013, 12, 31), Units::YEARS, true),
            'Dec 31 2012 to Dec 31 2013 should be 1 year'
        );
        self::assertEpochEquals(
            -1.5,
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2013, 7, 1), Units::YEARS, true),
            'Jan 1 2012 to Jul 1 2013 should be 1.5 years'
        );
        self::assertEpochEquals(
            -1.5,
            Epoch::from(2012, 1, 31)->diff(Epoch::from(2013, 7, 31), Units::YEARS, true),
            'Jan 31 2012 to Jul 31 2013 should be 1.5 years'
        );
        self::assertEpochEquals(
            -1 - 0.5 / 31 / 12,
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2013, 1, 1, 12), Units::YEARS, true),
            'Jan 1 2012 to Jan 1 2013 noon should be 1 + (0.5 / 31) / 12 years'
        );
        self::assertEpochEquals(
            -1.5 - 0.5 / 31 / 12,
            Epoch::from(2012, 1, 1)->diff(Epoch::from(2013, 7, 1, 12), Units::YEARS, true),
            'Jan 1 2012 to Jul 1 2013 noon should be 1.5 + (0.5 / 31) / 12 years'
        );
        self::assertGreaterThan(
            -1,
            Epoch::from(2012, 2, 29)->diff(Epoch::from(2013, 2, 28), Units::YEARS, true),
            'Feb 29 2012 to Feb 28 2013 should be 1 - (1 / 28.5) / 12 years'
        );
    }

    public function testInvalidDateStringReturnsZero(): void
    {
        self::assertEquals(
            0,
            Epoch::from(2012)->diff(chr(0))
        );
    }

    public function testDiffTimestamp(): void
    {
        self::assertEquals(
            -1,
            Epoch::from(2013)->diff(1359676800, Units::MONTHS)
        );
    }

    public function testDiffDateTime(): void
    {
        $input = new DateTime('@1359676800');
        self::assertEquals(
            -1,
            Epoch::from(2013)->diff($input, Units::MONTHS)
        );
    }

    protected static function assertEpochEquals(float|int $expected, float|int $actual, string $message = null): void
    {
        self::assertLessThan(
            0.00000001,
            abs($actual - $expected),
            sprintf('(%s === %s) = %s ', $actual, $expected, abs($actual - $expected)) . $message
        );
    }

    /** @psalm-return array{0: Epoch, 1: integer} */
    private static function getDSTForYear(int $year): array
    {
        $start = Epoch::from($year);
        $end = Epoch::from($year + 1);
        $current = clone $start;
        $last = null;

        while ($current->value() < $end->value()) {
            $last = clone $current;
            $current->add(24, Units::HOURS);
            if ($last->utcOffset() !== $current->utcOffset()) {
                $end = clone $current;
                $current = clone $last;
                break;
            }
        }

        while ($current->value() < $end->value()) {
            $last = clone $current;
            $current->add(1, Units::HOURS);
            if ($last->utcOffset() !== $current->utcOffset()) {
                break;
            }
        }

        return [$last, -($current->utcOffset() - $last->utcOffset()) / 60];
    }
}
