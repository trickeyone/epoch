<?php

declare(strict_types=1);

namespace Epoch\Test;

use Epoch\Utils;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use function sprintf;

#[CoversClass(Utils::class)]
class UtilsTest extends TestCase
{
    public function testIsLeapYear(): void
    {
        self::assertTrue(Utils::isLeapYear(2000));
        self::assertFalse(Utils::isLeapYear(2001));
    }

    public function testMod(): void
    {
        self::assertSame(1, Utils::mod(1, 12));
        self::assertSame(2, Utils::mod(2, 12));
        self::assertSame(2, Utils::mod(14, 12));
    }

    public function testBoundValue(): void
    {
        self::assertSame(1, Utils::boundValue(1, 1, 12));
        self::assertSame(4, Utils::boundValue(4, 1, 12));
        self::assertSame(12, Utils::boundValue(24, 1, 12));
        self::assertSame(1, Utils::boundValue(-15, 1, 12));
    }

    #[DataProvider('daysInMonthProvider')]
    public function testDaysInMonths(int $expectedDays, int $year, int $month): void
    {
        self::assertSame(
            $expectedDays,
            Utils::daysInMonths($year, $month),
            sprintf('Expected %s-%s to have %s days', $year, $month, $expectedDays)
        );
    }

    public static function daysInMonthProvider(): array
    {
        return [
            // leap year
            [ 31, 2000, 1 ],
            [ 29, 2000, 2 ],
            [ 31, 2000, 3 ],
            [ 30, 2000, 4 ],
            [ 31, 2000, 5 ],
            [ 30, 2000, 6 ],
            [ 31, 2000, 7 ],
            [ 31, 2000, 8 ],
            [ 30, 2000, 9 ],
            [ 31, 2000, 10 ],
            [ 30, 2000, 11 ],
            [ 31, 2000, 12 ],
            // non-leap year
            [ 31, 2001, 1 ],
            [ 28, 2001, 2 ],
            [ 31, 2001, 3 ],
            [ 30, 2001, 4 ],
            [ 31, 2001, 5 ],
            [ 30, 2001, 6 ],
            [ 31, 2001, 7 ],
            [ 31, 2001, 8 ],
            [ 30, 2001, 9 ],
            [ 31, 2001, 10 ],
            [ 30, 2001, 11 ],
            [ 31, 2001, 12 ],
        ];
    }
}
