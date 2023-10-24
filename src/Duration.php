<?php

declare(strict_types=1);

namespace Epoch;

use DateInterval;

use function floor;

/** @internal */
final class Duration
{
    public null|int|float $milliseconds = null;
    private ?int $seconds = null;
    private ?int $minutes = null;
    private ?int $hours = null;
    private ?int $days = null;
    private ?int $months = null;
    private ?int $years = null;

    public function __construct(int|float|DateInterval $amount = null, string $units = null)
    {
        if ($amount instanceof DateInterval) {
            $this->milliseconds = $amount->f;
            $this->seconds = $amount->s;
            $this->minutes = $amount->i;
            $this->hours = $amount->h;
            $this->days = $amount->d;
            $this->months = $amount->m;
            $this->years = $amount->y;
        } elseif (null !== $amount && null !== $units) {
            $years = 0;
            $quarters = 0;
            $months = 0;
            $weeks = 0;
            $days = 0;
            $hours = 0;
            $minutes = 0;
            $seconds = 0;
            $milliseconds = 0;
            if ($units === Units::YEARS) {
                $years = $amount;
            } elseif ($units === Units::QUARTERS) {
                $quarters = $amount;
            } elseif ($units === Units::MONTHS) {
                $months = $amount;
            } elseif ($units === Units::WEEKS) {
                $weeks = $amount;
            } elseif ($units === Units::DAYS) {
                $days = $amount;
            } elseif ($units === Units::HOURS) {
                $hours = $amount;
            } elseif ($units === Units::MINUTES) {
                $minutes = $amount;
            } elseif ($units === Units::SECONDS) {
                $seconds = $amount;
            } elseif ($units === Units::MILLISECONDS) {
                $milliseconds = $amount;
            }
            $months += $quarters * 3 + $years * 12;
            $days += $weeks * 7 + $months * 30;
            $hours += $days * 24;
            $minutes += $hours * 60;
            $seconds += $minutes * 60;
            $milliseconds += $seconds * 1000;

            $this->years = (int)floor($milliseconds / (Utils::MS_PER_DAY * 30 * 12));
            $milliseconds -= $this->years * (Utils::MS_PER_DAY * 30 * 12);
            $this->months = (int)floor($milliseconds / (Utils::MS_PER_DAY * 30));
            $milliseconds -= $this->months * (Utils::MS_PER_DAY * 30);
            $this->days = (int)floor($milliseconds / Utils::MS_PER_DAY);
            $milliseconds -= $this->days * Utils::MS_PER_DAY;
            $this->hours = (int)floor($milliseconds / Utils::MS_PER_HOUR);
            $milliseconds -= $this->hours * Utils::MS_PER_HOUR;
            $this->minutes = (int)floor($milliseconds / Utils::MS_PER_MINUTE);
            $milliseconds -= $this->minutes * Utils::MS_PER_MINUTE;
            $this->seconds = (int)floor($milliseconds / Utils::MS_PER_SECOND);
            $milliseconds -= $this->seconds * Utils::MS_PER_SECOND;
            $this->milliseconds = $milliseconds;
        }
    }

    public function toDateInterval(): DateInterval
    {
        $di = new DateInterval('P0D');
        $di->y = $this->years;
        $di->m = $this->months;
        $di->d = $this->days;
        $di->h = $this->hours;
        $di->i = $this->minutes;
        $di->s = $this->seconds;
        $di->f = $this->milliseconds / Utils::MS_PER_SECOND;

        return $di;
    }
}
