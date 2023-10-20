<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTime;
use Epoch\Epoch;
use Epoch\Units;
use Epoch\Utils;

use function round;
use function sprintf;

use const Epoch\MS_PER_HOUR;
use const Epoch\MS_PER_MINUTE;
use const Epoch\MS_PER_SECOND;
use const Epoch\MU_PER_SECOND;

/** @internal */
trait StartEndOfTrait
{
    public function startOf(string $unit = Units::MILLISECONDS): Epoch
    {
        $time = $this->value();
        switch ($unit) {
            case Units::YEARS:
                $time = self::startOfDate($this->year(), 1, 1);
                break;
            case Units::QUARTERS:
                $time = self::startOfDate(
                    $this->year(),
                    ($this->month() - ($this->month() % 3)) + 1,
                    1
                );
                break;
            case Units::MONTHS:
                $time = self::startOfDate($this->year(), $this->month(), 1);
                break;
            case Units::WEEKS:
                $time = self::startOfDate($this->year(), $this->month(), $this->day() - $this->weekday());
                break;
            case Units::DAYS:
                $time = self::startOfDate($this->year(), $this->month(), $this->day());
                break;
            case Units::HOURS:
                $time -= Utils::mod(
                    $time + $this->utcOffset() * MS_PER_MINUTE,
                    MS_PER_HOUR
                );
                break;
            case Units::MINUTES:
                $time -= Utils::mod($time, MS_PER_MINUTE);
                break;
            case Units::SECONDS:
                $time -= Utils::mod($time, MS_PER_SECOND);
                break;
            default:
        }
        $time = $time / MS_PER_SECOND;
        $this->date->setTimestamp((int)$time);
        $this->date->setTime(
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            (int)round(($time - (int)$time) * MU_PER_SECOND)
        );

        return $this;
    }

    public function endOf(string $unit = Units::MILLISECONDS): Epoch
    {
        $time = $this->value();
        switch ($unit) {
            case Units::YEARS:
                $time = self::startOfDate($this->year() + 1, 1, 1) - 1;
                break;
            case Units::QUARTERS:
                $time = self::startOfDate(
                    $this->year(),
                    (($this->month() - 1) - (($this->month() - 1) % 3)) + 4,
                    1
                ) - 1;
                break;
            case Units::MONTHS:
                $time = self::startOfDate($this->year(), $this->month() + 1, 1) - 1;
                break;
            case Units::WEEKS:
                $time = self::startOfDate(
                    $this->year(),
                    $this->month(),
                    $this->day() - $this->weekday() + 7
                ) - 1;
                break;
            case Units::DAYS:
                $time = self::startOfDate($this->year(), $this->month(), $this->day() + 1) - 1;
                break;
            case Units::HOURS:
                $time += MS_PER_HOUR - Utils::mod(
                        $time + $this->utcOffset() * MS_PER_MINUTE,
                        MS_PER_HOUR
                    ) - 1;
                break;
            case Units::MINUTES:
                $time += MS_PER_MINUTE - Utils::mod($time, MS_PER_MINUTE) - 1;
                break;
            case Units::SECONDS:
                $time += MS_PER_SECOND - Utils::mod($time, MS_PER_SECOND) - 1;
                break;
            default:
        }
        $time = $time / MS_PER_SECOND;
        $this->date->setTimestamp((int)$time);
        $this->date->setTime(
            $this->hours(),
            $this->minutes(),
            $this->seconds(),
            (int)round(($time - (int)$time) * MU_PER_SECOND)
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

        return MS_PER_SECOND *
            (new DateTime(sprintf('%s-%02d-%02dT00:00:00', $year, $month, $day), $this->timezone()))->getTimestamp();
    }
}
