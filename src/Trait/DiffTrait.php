<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTimeInterface;
use Epoch\Epoch;
use Epoch\Exception\DateCreationException;
use Epoch\Units;
use Epoch\Utils;

use function abs;
use function round;

trait DiffTrait
{
    public function diff(
        null|int|string|DateTimeInterface|Epoch $input,
        Units $units = Units::MILLISECONDS,
        bool $asFloat = false
    ): int|float {
        try {
            $compare = self::createFrom($input, null, $this->timezone());
        } catch (DateCreationException) {
            return 0;
        }

        $zoneDelta = ($compare->utcOffset() - $this->utcOffset()) * Utils::MS_PER_SECOND;
        $output = match ($units) {
            Units::YEARS => self::monthDiff($this, $compare) / 12,
            Units::MONTHS => (fn(float $output) => $asFloat
                ? $output
                : (int)round($output))(self::monthDiff($this, $compare)),
            Units::QUARTERS => self::monthDiff($this, $compare) / 3,
            Units::SECONDS => ($this->value() - $compare->value()) / Utils::MS_PER_SECOND,
            Units::MINUTES => ($this->value() - $compare->value()) / Utils::MS_PER_MINUTE,
            Units::HOURS => ($this->value() - $compare->value()) / Utils::MS_PER_HOUR,
            Units::DAYS => ($this->value() - $compare->value() - $zoneDelta) / Utils::MS_PER_DAY,
            Units::WEEKS => ($this->value() - $compare->value() - $zoneDelta) / Utils::MS_PER_WEEK,
            default => $this->value() - $compare->value(),
        };

        return $asFloat ? $output : Utils::absFloor($output);
    }

    private static function monthDiff(Epoch $a, Epoch $b): float
    {
        if ($a->day() < $b->day()) {
            return -(self::monthDiff($b, $a)); // NOSONAR
        }

        $wholeMonthDiff = ($b->year() - $a->year()) * 12 + (($b->month() - 1) - ($a->month() - 1));
        $anchor = self::cloneForValue($a, $wholeMonthDiff, Units::MONTHS)->value();
        if ($b->value() - $anchor < 0) {
            $anchor2 = self::cloneForValue($a, $wholeMonthDiff - 1, Units::MONTHS)->value();
            $adjust = ($b->value() - $anchor) / ($anchor - $anchor2);
        } else {
            $anchor2 = self::cloneForValue($a, $wholeMonthDiff + 1, Units::MONTHS)->value();
            $adjust = ($b->value() - $anchor) / ($anchor2 - $anchor);
        }

        return -($wholeMonthDiff + $adjust) ?: 0;
    }

    public static function cloneForValue(Epoch $source, int $value, Units $units): Epoch
    {
        return $value < 0 ? $source->clone()->subtract(abs($value), $units) : $source->clone()->add($value, $units);
    }
}
