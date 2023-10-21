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
        int|string|DateTimeInterface|Epoch $input,
        string $units = Units::MILLISECONDS,
        bool $asFloat = false
    ): int|float {
        try {
            $compare = self::createFrom($input, null, $this->timezone());
        } catch (DateCreationException) {
            return 0;
        }

        $zoneDelta = ($compare->utcOffset() - $this->utcOffset()) * Utils::MS_PER_SECOND;
        switch ($units) {
            case Units::YEARS:
                $output = self::monthDiff($this, $compare) / 12;
                break;
            case Units::MONTHS:
                $output = self::monthDiff($this, $compare);
                $output = $asFloat ? $output : (int)round($output);
                break;
            case Units::QUARTERS:
                $output = self::monthDiff($this, $compare) / 3;
                break;
            case Units::SECONDS:
                $output = ($this->value() - $compare->value()) / Utils::MS_PER_SECOND;
                break;
            case Units::MINUTES:
                $output = ($this->value() - $compare->value()) / Utils::MS_PER_MINUTE;
                break;
            case Units::HOURS:
                $output = ($this->value() - $compare->value()) / Utils::MS_PER_HOUR;
                break;
            case Units::DAYS:
                $output = ($this->value() - $compare->value() - $zoneDelta) / Utils::MS_PER_DAY;
                break;
            case Units::WEEKS:
                $output = ($this->value() - $compare->value() - $zoneDelta) / Utils::MS_PER_WEEK;
                break;
            default:
                $output = $this->value() - $compare->value();
        }

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

    public static function cloneForValue(Epoch $source, int $value, string $units): Epoch
    {
        return $value < 0 ? $source->clone()->subtract(abs($value), $units) : $source->clone()->add($value, $units);
    }
}
