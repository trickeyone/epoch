<?php

declare(strict_types=1);

namespace Epoch\Test;

use DateInterval;
use Epoch\Duration;
use PHPUnit\Framework\TestCase;

class DurationTest extends TestCase
{
    public function testCreateFromDateInterval(): void
    {
        $dateInterval = new DateInterval('P1Y2M3DT4H5M6S');
        $duration = new Duration($dateInterval);

        self::assertEquals($dateInterval, $duration->toDateInterval());
    }
}
