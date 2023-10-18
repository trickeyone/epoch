<?php

declare(strict_types=1);

namespace Epoch\Trait;

use Epoch\DateTimeFormats;
use Epoch\Epoch;
use Epoch\Units;
use Epoch\Utils;

use function abs;
use function ceil;

/** @internal */
trait GetSetTrait
{
    public function weekYear(): int
    {
        return (int)$this->date->format(DateTimeFormats::WEEK_NUMBER_YEAR);
    }

    public function dayOfYear(): int
    {
        return (int)$this->date->format(DateTimeFormats::DAY_NUMBER_YEAR) + 1;
    }

    public function isoWeekYear(): int
    {
        return (int)$this->date->format(DateTimeFormats::ISO_WEEK_NUMBER);
    }

    public function year(): int
    {
        return (int)$this->date->format(DateTimeFormats::FULL_YEAR);
    }

    public function setYear(int|string $value): Epoch
    {
        $day = $this->day();
        $value = (int)$value;
        if (
            Utils::isLeapYear($value) &&
            $this->month() === 2 &&
            $this->day() === 29
        ) {
            $day = Utils::daysInMonths($value, $this->month());
        }
        $this->date->setDate($value, $this->month(), $day);

        return $this;
    }

    public function isLeapYear(): bool
    {
        return Utils::isLeapYear($this->year());
    }

    public function month(): int
    {
        return (int)$this->date->format(DateTimeFormats::MONTH);
    }

    public function setMonth(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 1, 12);
        $this->date->setDate($this->year(), $value, $this->day());

        return $this;
    }

    public function quarter(): int
    {
        return (int)ceil($this->month() / 3);
    }

    public function day(): int
    {
        return (int)$this->date->format(DateTimeFormats::DAY);
    }

    public function setDay(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 1, Utils::daysInMonths($this->year(), $this->month()));
        $this->date->setDate($this->year(), $this->month(), $value);

        return $this;
    }

    public function daysInMonth(): int
    {
        return Utils::daysInMonths($this->year(), $this->month());
    }

    public function weekday(): int
    {
        return (int)$this->date->format(DateTimeFormats::WEEKDAY);
    }

    /**
     * @param int $value Day of Week (0-6), negative values supported
     * @return Epoch
     */
    public function setWeekday(int $value): Epoch
    {
        $value = abs($value) * ($value / abs($value ?: 1));
        $this->add($value - $this->weekday(), Units::DAYS);

        return $this;
    }

    public function isoWeekday(): int
    {
        return (int)$this->date->format(DateTimeFormats::ISO_WEEKDAY);
    }

    /**
     * @param int $value ISO Day of Week (1-7), negative values supported
     * @return Epoch
     */
    public function setIsoWeekday(int $value): Epoch
    {
        $value = abs($value) * ($value / abs($value ?: 1));
        $this->setWeekday($this->weekday() % 7 ? $value : $value - 7);

        return $this;
    }

    public function hours(): int
    {
        return (int)$this->date->format(DateTimeFormats::HOURS);
    }

    public function setHours(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 1, 24);
        $this->date->setTime($value, $this->minutes(), $this->seconds(), $this->microseconds());

        return $this;
    }

    public function minutes(): int
    {
        return (int)$this->date->format(DateTimeFormats::MINUTES);
    }

    public function setMinutes(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 1, 60);
        $this->date->setTime($this->hours(), $value, $this->seconds(), $this->microseconds());

        return $this;
    }

    public function seconds(): int
    {
        return (int)$this->date->format(DateTimeFormats::SECONDS);
    }

    public function setSeconds(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 1, 60);
        $this->date->setTime($this->hours(), $this->minutes(), $value, $this->microseconds());

        return $this;
    }

    public function milliseconds(): int
    {
        return (int)$this->date->format(DateTimeFormats::MILLISECONDS);
    }

    public function setMilliseconds(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 0, 999);
        $this->setMicroseconds($value * MS_PER_SECOND);

        return $this;
    }

    public function microseconds(): int
    {
        return (int)$this->date->format(DateTimeFormats::MICROSECONDS);
    }

    public function setMicroseconds(int|string $value): Epoch
    {
        $value = Utils::boundValue($value, 0, 999999);
        $this->date->setTime($this->hours(), $this->minutes(), $this->seconds(), $value);

        return $this;
    }

    /** Unix Timestamp */
    public function timestamp(bool $milliseconds = false): int|float
    {
        return $milliseconds
            ? (float)($this->date->format(DateTimeFormats::TIMESTAMP . '.' . DateTimeFormats::MILLISECONDS))
            : $this->date->getTimestamp();
    }

    /**
     * @uses Epoch::timestamp()
     * @return int Unix Timestamp in milliseconds
     */
    public function value(): int
    {
        return (int)($this->timestamp(true) * MS_PER_SECOND);
    }
}
