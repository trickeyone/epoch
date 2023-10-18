<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    /** Some examples taken from @link(https://en.wikipedia.org/wiki/ISO_week) */
    public function testIsoWeekYear(): void
    {
        self::assertSame(2004, Epoch::from(2005, 1, 1)->isoWeekYear());
        self::assertSame(2004, Epoch::from(2005, 1, 2)->isoWeekYear());
        self::assertSame(2005, Epoch::from(2005, 1, 3)->isoWeekYear());
        self::assertSame(2005, Epoch::from(2005, 11, 31)->isoWeekYear());
        self::assertSame(2005, Epoch::from(2006, 1, 1)->isoWeekYear());
        self::assertSame(2006, Epoch::from(2006, 1, 2)->isoWeekYear());
    }
}
