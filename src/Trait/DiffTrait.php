<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTimeInterface;
use Epoch\Epoch;
use Epoch\Exception\DateCreationException;
use Epoch\Units;
use Epoch\Utils;

trait DiffTrait
{
    public function diff(
        string|DateTimeInterface|Epoch $input,
        string $units = Units::MILLISECOND,
        bool $asFloat = false
    ): int|float {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return 0;
        }

        $zoneDelta = ($compare->utcOffset() - $this->utcOffset()) * MS_PER_SECOND;
        $output = 0;
        switch ($units) {
            case Units::YEAR:
                $output = self::monthDiff($this, $compare) / 12;
                break;
            case Units::MONTH:
                $output = self::monthDiff($this, $compare);
                break;
            case Units::QUARTER:
                $output = self::monthDiff($this, $compare) / 3;
                break;
            case Units::SECOND:
                $output = ($this->value() - $compare->value()) / MS_PER_SECOND;
                break;
            case Units::MINUTE:
                $output = ($this->value() - $compare->value()) / MS_PER_MINUTE;
                break;
            case Units::HOUR:
                $output = ($this->value() - $compare->value()) / MS_PER_HOUR;
                break;
            case Units::DAY:
                $output = ($this->value() - $compare->value() - $zoneDelta) / MS_PER_DAY;
                break;
            case Units::WEEK:
                $output = ($this->value() - $compare->value() - $zoneDelta) / MS_PER_WEEK;
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

        $wholeMonthDiff = ($b->year() - $a->year()) * 12 + ($b->month() - $a->month());
        $anchor = $a->clone()->add($wholeMonthDiff, Units::MONTH)->value();
        if ($b->value() - $anchor < 0) {
            $anchor2 = $a->clone()->add($wholeMonthDiff - 1, Units::MONTH)->value();
            $adjust = ($b->value() - $anchor) / ($anchor / $anchor2);
        } else {
            $anchor2 = $a->clone()->add($wholeMonthDiff + 1, Units::MONTH)->value();
            $adjust = ($b->value() - $anchor) / ($anchor2 - $anchor);
        }

        return -($wholeMonthDiff + $adjust) ?: 0;
    }
}
