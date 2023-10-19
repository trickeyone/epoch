<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use DateTimeZone;
use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class TimezoneTest extends TestCase
{
    public function testTimezoneValues(): void
    {
        $timezone = new DateTimeZone('America/Chicago');
        $expectedName = $timezone->getName();

        self::assertEquals(
            $expectedName,
            Epoch::from(2000)->setTimezone($timezone)->timezoneName()
        );
        self::assertEquals(
            'CST',
            Epoch::from(2000, 1, 1)->setTimezone($timezone)->timezoneAbbr()
        );
        self::assertEquals(
            'CDT',
            Epoch::from(2000)->add(6, Units::MONTHS)->setTimezone($timezone)->timezoneAbbr()
        );
    }
}
