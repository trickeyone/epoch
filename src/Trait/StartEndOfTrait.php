<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTime;
use Epoch\Epoch;
use Epoch\Units;
use Epoch\Utils;

use function round;
use function sprintf;

/** @internal */
trait StartEndOfTrait
{
    public function startOf(Units $units = Units::MILLISECONDS): Epoch
    {
        $time = $this->value();
        $time = match ($units) {
            Units::YEARS => self::startOfDate($this->year(), 1, 1),
            Units::QUARTERS => self::startOfDate(
                $this->year(),
                ($this->month() - ($this->month() % 3)) + 1,
                1
            ),
            Units::MONTHS => self::startOfDate($this->year(), $this->month(), 1),
            Units::WEEKS => self::startOfDate($this->year(), $this->month(), $this->day() - $this->weekday()),
            Units::DAYS => self::startOfDate($this->year(), $this->month(), $this->day()),
            Units::HOURS => $time - Utils::mod(
                    $time + $this->utcOffset() * Utils::MS_PER_MINUTE,
                    Utils::MS_PER_HOUR
                ),
            Units::MINUTES => $time - Utils::mod($time, Utils::MS_PER_MINUTE),
            Units::SECONDS => $time - Utils::mod($time, Utils::MS_PER_SECOND),
            default => $time,
        };
        $time = $time / Utils::MS_PER_SECOND;
        $this->date->setTimestamp((int)$time);
        $this->date->setTime(
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            (int)round(($time - (int)$time) * Utils::MU_PER_SECOND)
        );

        return $this;
    }

    public function endOf(Units $units = Units::MILLISECONDS): Epoch
    {
        $time = $this->value();
        $time = match ($units) {
            Units::YEARS => self::startOfDate($this->year() + 1, 1, 1) - 1,
            Units::QUARTERS => self::startOfDate(
                    $this->year(),
                    (($this->month() - 1) - (($this->month() - 1) % 3)) + 4,
                    1
                ) - 1,
            Units::MONTHS => self::startOfDate($this->year(), $this->month() + 1, 1) - 1,
            Units::WEEKS => self::startOfDate(
                    $this->year(),
                    $this->month(),
                    $this->day() - $this->weekday() + 7
                ) - 1,
            Units::DAYS => self::startOfDate($this->year(), $this->month(), $this->day() + 1) - 1,
            Units::HOURS => $time + Utils::MS_PER_HOUR - Utils::mod(
                    $time + $this->utcOffset() * Utils::MS_PER_MINUTE,
                    Utils::MS_PER_HOUR
                ) - 1,
            Units::MINUTES => $time + Utils::MS_PER_MINUTE - Utils::mod($time, Utils::MS_PER_MINUTE) - 1,
            Units::SECONDS => $time + Utils::MS_PER_SECOND - Utils::mod($time, Utils::MS_PER_SECOND) - 1,
            default => $time,
        };
        $time = $time / Utils::MS_PER_SECOND;
        $this->date->setTimestamp((int)$time);
        $this->date->setTime(
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            (int)round(($time - (int)$time) * Utils::MU_PER_SECOND)
        );

        return $this;
    }

    private function startOfDate(int $year, int $month, int $day): int
    {
        if ($day <= 0) {
            $month -= 1;
        } elseif ($day > Utils::daysInMonths($year, $month)) {
            $month += 1;
        }
        if ($month <= 0) {
            $year -= 1;
            $month = 12;
        } elseif ($month > 12) {
            $year += 1;
            $month = 1;
        }
        if ($day <= 0) {
            $day = Utils::daysInMonths($year, $month) + $day;
        } elseif ($day > Utils::daysInMonths($year, $month)) {
            $day += -(Utils::daysInMonths($year, $month));
        }

        return Utils::MS_PER_SECOND *
            (new DateTime(sprintf('%s-%02d-%02dT00:00:00', $year, $month, $day), $this->timezone()))->getTimestamp();
    }
}
