<?php

declare(strict_types=1);

namespace Epoch;

use function ceil;
use function floor;
use function max;
use function min;

/** @internal */
final class Utils
{
    public static function isLeapYear(int $year): bool
    {
        return ($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0;
    }

    public static function daysInMonths(int $year, int $month): int
    {
        $modMonth = self::mod($month, 12);
        $year += ($month - $modMonth) / 12;

        return $modMonth === 2
            ? (self::isLeapYear($year) ? 29 : 28)
            : 30 + (($month + ($month / 8)) % 2);
    }

    public static function mod(int $n, int $x): int
    {
        return (($n % $x) + $x) % $x;
    }

    public static function boundValue(int|string $value, int $min, int $max): int
    {
        return max(min($value, $max), $min);
    }

    public static function absFloor(int|float $number): float
    {
        return $number < 0 ? (ceil($number) ?: 0) : floor($number);
    }
}
