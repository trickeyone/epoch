<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTimeZone;
use Epoch\DateTimeFormats;
use Epoch\Epoch;

trait TimezoneTrait
{
    public function timezone(): DateTimeZone
    {
        return $this->date->getTimezone();
    }

    public function setTimezone(DateTimeZone $timeZone): Epoch
    {
        $this->date->setTimezone($timeZone);

        return $this;
    }

    public function timezoneAbbr(): string
    {
        return $this->date->format(DateTimeFormats::TIMEZONE_ABBR);
    }

    public function timezoneName(): string
    {
        return $this->date->format(DateTimeFormats::TIMEZONE_NAME);
    }

    public function isDST(): bool
    {
        return (bool)((int)$this->date->format(DateTimeFormats::TIMEZONE_DST));
    }
}
