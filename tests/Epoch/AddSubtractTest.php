<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use Epoch\Units;
use PHPUnit\Framework\TestCase;

class AddSubtractTest extends TestCase
{
    public function testAdd(): void
    {
        $a = Epoch::create();
        $a->setYear(2011)->setMonth(10)->setDay(12)->setHours(6)->setMinutes(7)->setSeconds(8)->setMilliseconds(500);

        self::assertSame(550, $a->add(50, Units::MILLISECONDS)->milliseconds(), 'Adds milliseconds');
        self::assertSame(9, $a->add(1, Units::SECONDS)->seconds(), 'Add seconds');
        self::assertSame(8, $a->add(1, Units::MINUTES)->minutes(), 'Add minutes');
        self::assertSame(7, $a->add(1, Units::HOURS)->hours(), 'Add hours');
        self::assertSame(13, $a->add(1, Units::DAYS)->day(), 'Add days');
        self::assertSame(20, $a->add(1, Units::WEEKS)->day(), 'Add weeks');
        self::assertSame(11, $a->add(1, Units::MONTHS)->month(), 'Add months');
        self::assertSame(2012, $a->add(1, Units::YEARS)->year(), 'Add years');
        self::assertSame(1, $a->add(1, Units::QUARTERS)->quarter(), 'Add quarters');
        self::assertSame(5, $a->add(1, Units::QUARTERS)->month(), 'Add quarters');
    }

    public function testAddDecimal(): void
    {
        $a = Epoch::from(2011, 10, 12, 6, 7, 8, 500);
        $a->add(1.25, Units::SECONDS);
        self::assertEquals(9, $a->seconds());
        self::assertEquals(750, $a->milliseconds());
    }

    public function testAddWithNegativeAmountSubtracts(): void
    {
        self::assertSame(
            5,
            Epoch::from(2011, 10, 6)->add(-1, Units::DAYS)->day()
        );
    }

    public function testSubtract(): void
    {
        $a = Epoch::create();
        $a->setYear(2011)->setMonth(10)->setDay(12)->setHours(6)->setMinutes(7)->setSeconds(8)->setMilliseconds(500);

        self::assertSame(450, $a->subtract(50, Units::MILLISECONDS)->milliseconds(), 'Subtracts milliseconds');
        self::assertSame(7, $a->subtract(1, Units::SECONDS)->seconds(), 'Subtract seconds');
        self::assertSame(6, $a->subtract(1, Units::MINUTES)->minutes(), 'Subtract minutes');
        self::assertSame(5, $a->subtract(1, Units::HOURS)->hours(), 'Subtract hours');
        self::assertSame(11, $a->subtract(1, Units::DAYS)->day(), 'Subtract days');
        self::assertSame(4, $a->subtract(1, Units::WEEKS)->day(), 'Subtract weeks');
        self::assertSame(9, $a->subtract(1, Units::MONTHS)->month(), 'Subtract months');
        self::assertSame(2010, $a->subtract(1, Units::YEARS)->year(), 'Subtract years');
        self::assertSame(2, $a->subtract(1, Units::QUARTERS)->quarter(), 'Subtract quarters');
        self::assertSame(3, $a->subtract(1, Units::QUARTERS)->month(), 'Subtract quarters');
    }

    public function testAddAcrossDST(): void
    {
        $a = Epoch::from(2011, 3, 12, 5, 0, 0);
        $b = Epoch::from(2011, 3, 12, 5, 0, 0);
        $c = Epoch::from(2011, 3, 12, 5, 0, 0);
        $d = Epoch::from(2011, 3, 12, 5, 0, 0);
        $e = Epoch::from(2011, 3, 12, 5, 0, 0);

        $a->add(1, Units::DAYS);
        $b->add(24, Units::HOURS);
        $c->add(1, Units::MONTHS);
        $e->add(1, Units::QUARTERS);

        self::assertSame(5, $a->hours(), 'adding days over DST difference should result in the same hour');
        if ($b->isDST() && !$d->isDST()) {
            self::assertSame(6, $b->hours(), 'adding hours over DST difference should result in a different hour');
        } elseif (!$b->isDST() && $d->isDST()) {
            self::assertSame(4, $b->hours(), 'adding hours over DST difference should result in a different hour');
        } else {
            self::assertSame(
                5,
                $b->hours(),
                'adding hours over DST difference should result in a same hour if the timezone does not have daylight savings time'
            );
        }
        self::assertSame(5, $c->hours(), 'adding months over DST difference should result in the same hour');
        self::assertSame(5, $e->hours(), 'adding quarters over DST difference should result in the same hour');
    }
}
