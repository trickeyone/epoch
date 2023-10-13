<?php

declare(strict_types=1);

namespace Epoch\Trait;

use Epoch\DateTimeFormats;

trait OffsetTrait
{
    /** UTC offset in seconds */
    public function utcOffset(): int
    {
        return (int)$this->date->format(DateTimeFormats::UTC_OFFSET);
    }
}
