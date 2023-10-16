<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use DateTimeZone;
use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class DiffTest extends TestCase
{
    public function testDiffOneHour(): void
    {
        $now = Epoch::create();
        $oneHour = clone $now;
        $oneHour->setHours($now->hours() + 1);

        self::assertSame(60 * 60 * 1000, $oneHour->diff($now), '1 hour from now = 3600000');
    }

    public function testDiffNegative(): void
    {
        self::assertSame(
            -1,
            Epoch::from(2010)
                ->diff(Epoch::from(2011), Units::YEAR),
            'years diff'
        );
        self::assertSame(
            -2,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 3), Units::MONTH),
            'months diff'
        );
        self::assertSame(
            0,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 7), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            -1,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 8), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            -2,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 21), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            -3,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 22), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            -3,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 4), Units::DAY),
            'days diff'
        );
        self::assertSame(
            -4,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 1, 4), Units::HOUR),
            'hours diff'
        );
        self::assertSame(
            -5,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 1, 0, 5), Units::MINUTE),
            'minutes diff'
        );
        self::assertSame(
            -6,
            Epoch::from(2010)
                ->diff(Epoch::from(2010, 1, 1, 0, 0, 6), Units::SECOND),
            'seconds diff'
        );
    }

    public function testDiffPositive(): void
    {
        self::assertSame(
            1,
            Epoch::from(2011)
                ->diff(Epoch::from(2010), Units::YEAR),
            'years diff'
        );
        self::assertSame(
            2,
            Epoch::from(2010, 3)
                ->diff(Epoch::from(2010), Units::MONTH),
            'months diff'
        );
        self::assertSame(
            3,
            Epoch::from(2010, 1, 4)
                ->diff(Epoch::from(2010), Units::DAY),
            'days diff'
        );
        self::assertSame(
            0,
            Epoch::from(2010, 1, 7)
                ->diff(Epoch::from(2010), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            1,
            Epoch::from(2010, 1, 8)
                ->diff(Epoch::from(2010), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            2,
            Epoch::from(2010, 1, 21)
                ->diff(Epoch::from(2010), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            3,
            Epoch::from(2010, 1, 22)
                ->diff(Epoch::from(2010), Units::WEEK),
            'weeks diff'
        );
        self::assertSame(
            4,
            Epoch::from(2010, 1, 1, 4)
                ->diff(Epoch::from(2010), Units::HOUR),
            'hours diff'
        );
        self::assertSame(
            5,
            Epoch::from(2010, 1, 1, 0, 5)
                ->diff(Epoch::from(2010), Units::MINUTE),
            'minutes diff'
        );
        self::assertSame(
            6,
            Epoch::from(2010, 1, 1, 0, 0, 6)
                ->diff(Epoch::from(2010), Units::SECOND),
            'seconds diff'
        );
    }

    public function testDiffEndOfMonth(): void
    {
        self::assertSame(
            1,
            Epoch::from(2016, 2, 29)
                ->diff(Epoch::from(2016, 1, 30), Units::MONTH),
            'Feb 29 to Jan 30 should be 1 month'
        );
        self::assertSame(
            1,
            Epoch::from(2016, 2, 29)
                ->diff(Epoch::from(2016, 1, 31), Units::MONTH),
            'Feb 29 to Jan 31 should be 1 month'
        );
        self::assertSame(
            1,
            Epoch::from(2016, 5, 31)
                ->add(1, Units::MONTH)
                ->diff(Epoch::from(2016, 5, 31), Units::MONTH),
            '(May 31 plus 1 month) to May 31 should be 1 month diff'
        );
    }

    public function testEndOfMonthWithTimeBehind(): void
    {
        self::assertSame(
            1,
            Epoch::from(2017, 3, 31)
                ->diff(Epoch::from(2017, 2, 28), Units::MONTH),
            'Feb 28 to March 31 should be 1 month'
        );
        self::assertSame(
            -1,
            Epoch::from(2017, 2, 28)
                ->diff(Epoch::from(2017, 3, 31), Units::MONTH),
            'Feb 28 to March 31 should be 1 month'
        );
    }

    public function testDiffAcrossDST(): void
    {
        [$a, $diff] = self::getDSTForYear(2012);
        $b = $a->clone()->add(12, Units::HOUR);

        self::assertSame(
            12 * 60 * 60 * 1000,
            $b->diff($a, Units::MILLISECOND, true),
            'ms diff across DST'
        );
        self::assertSame(
            12 * 60 * 60,
            $b->diff($a, Units::SECOND, true),
            'second diff across DST'
        );
        self::assertSame(
            12 * 60,
            $b->diff($a, Units::MINUTE, true),
            'minute diff across DST'
        );
        self::assertSame(
            12,
            $b->diff($a, Units::HOUR, true),
            'hour diff across DST'
        );
        self::assertSame(
            (12 - $diff) / 24,
            $b->diff($a, Units::DAY, true),
            'day diff across DST'
        );
        self::assertSame(
            (12 - $diff) / 24 / 7,
            $b->diff($a, Units::WEEK, true),
            'week diff across DST'
        );
        self::assertGreaterThan(
            0.95 / (2 * 31),
            $b->diff($a, Units::MONTH, true),
            'month diff across DST, lower bound'
        );
        self::assertLessThan(
            1.05 / (2 * 28),
            $b->diff($a, Units::MONTH, true),
            'month diff across DST, upper bound'
        );
        self::assertGreaterThan(
            0.95 / (2 * 31 * 12),
            $b->diff($a, Units::YEAR, true),
            'year diff across DST, lower bound'
        );
        self::assertLessThan(
            1.05 / (2 * 28 * 12),
            $b->diff($a, Units::YEAR, true),
            'year diff across DST, upper bound'
        );
    }

    /** @psalm-return array{0: Epoch, 1: integer} */
    public static function getDSTForYear(int $year): array
    {
        $start = Epoch::from($year);
        $end = Epoch::from($year + 1);
        $current = clone $start;
        $last = null;

        while ($current->value() < $end->value()) {
            $last = clone $current;
            $current->add(24, Units::HOUR);
            if ($last->utcOffset() !== $current->utcOffset()) {
                $end = clone $current;
                $current = clone $last;
                break;
            }
        }

        while ($current->value() < $end->value()) {
            $last = clone $current;
            $current->add(1, Units::HOUR);
            if ($last->utcOffset() !== $current->utcOffset()) {
                break;
            }
        }

        return [$last, -($current->utcOffset() - $last->utcOffset()) / 60];
    }
}
