<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTime;
use Epoch\Epoch;
use Epoch\Units;
use Epoch\Utils;

use function round;
use function sprintf;

const MS_PER_SECOND = 1000;
const MU_PER_SECOND = MS_PER_SECOND * 10;
const MS_PER_MINUTE = 60 * MS_PER_MINUTE;
const MS_PER_HOUR = 60 * MS_PER_MINUTE;
const MS_PER_DAY = 24 * MS_PER_HOUR;
const MS_PER_WEEK = 7 * MS_PER_DAY;

/** @internal */
trait StartEndOfTrait
{
    public function startOf(string $unit = Units::MILLISECOND): Epoch
    {
        $time = $this->value();
        switch ($unit) {
            case Units::YEAR:
                $time = self::startOfDate($this->year(), 1, 1);
                break;
            case Units::QUARTER:
                $time = self::startOfDate(
                    $this->year(),
                    $this->month() - ($this->month() % 3),
                    1
                );
                break;
            case Units::MONTH:
                $time = self::startOfDate($this->year(), $this->month(), 1);
                break;
            case Units::WEEK:
                $time = self::startOfDate(
                    $this->year(),
                    $this->month(),
                    $this->day() - $this->weekday()
                );
                break;
            case Units::DAY:
                $time = self::startOfDate($this->year(), $this->month(), $this->day());
                break;
            case Units::HOUR:
                $time -= Utils::mod(
                    $time + $this->utcOffset() * MS_PER_MINUTE,
                    MS_PER_HOUR
                );
                break;
            case Units::MINUTE:
                $time -= Utils::mod($time, MS_PER_MINUTE);
                break;
            case Units::SECOND:
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

    public function endOf(string $unit = Units::MILLISECOND): Epoch
    {
        $time = $this->value();
        switch ($unit) {
            case Units::YEAR:
                $time = self::startOfDate($this->year() + 1, 1, 1) - 1;
                break;
            case Units::QUARTER:
                $time = self::startOfDate(
                    $this->year(),
                    $this->month() - ($this->month() % 3) + 3,
                    1
                ) - 1;
                break;
            case Units::MONTH:
                $time = self::startOfDate($this->year(), $this->month() + 1, 1) - 1;
                break;
            case Units::WEEK:
                $time = self::startOfDate(
                    $this->year(),
                    $this->month(),
                    $this->day() - $this->weekday() + 7
                ) - 1;
                break;
            case Units::DAY:
                $time = self::startOfDate($this->year(), $this->month(), $this->day() + 1) - 1;
                break;
            case Units::HOUR:
                $time += MS_PER_HOUR - Utils::mod(
                        $time + $this->utcOffset() * MS_PER_MINUTE,
                        MS_PER_HOUR
                    ) - 1;
                break;
            case Units::MINUTE:
                $time += MS_PER_MINUTE - Utils::mod($time, MS_PER_MINUTE) - 1;
                break;
            case Units::SECOND:
                $time -= Utils::mod($time, MS_PER_SECOND) - 1;
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
        return MS_PER_SECOND *
            (new DateTime(sprintf('%s-%02d-%02dT00:00:00', $year, $month, $day), $this->timezone()))->getTimestamp();
    }
}
