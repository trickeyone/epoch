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

        self::assertSame(550, $a->add(50, Units::MILLISECOND)->milliseconds(), 'Adds milliseconds');
        self::assertSame(9, $a->add(1, Units::SECOND)->seconds(), 'Add seconds');
        self::assertSame(8, $a->add(1, Units::MINUTE)->minutes(), 'Add minutes');
        self::assertSame(7, $a->add(1, Units::HOUR)->hours(), 'Add hours');
        self::assertSame(13, $a->add(1, Units::DAY)->day(), 'Add days');
        self::assertSame(20, $a->add(1, Units::WEEK)->day(), 'Add weeks');
        self::assertSame(11, $a->add(1, Units::MONTH)->month(), 'Add months');
        self::assertSame(2012, $a->add(1, Units::YEAR)->year(), 'Add years');
        self::assertSame(1, $a->add(1, Units::QUARTER)->quarter(), 'Add quarters');
        self::assertSame(5, $a->add(1, Units::QUARTER)->month(), 'Add quarters');
    }

    public function testSubtract(): void
    {
        $a = Epoch::create();
        $a->setYear(2011)->setMonth(10)->setDay(12)->setHours(6)->setMinutes(7)->setSeconds(8)->setMilliseconds(500);

        self::assertSame(450, $a->subtract(50, Units::MILLISECOND)->milliseconds(), 'Subtracts milliseconds');
        self::assertSame(7, $a->subtract(1, Units::SECOND)->seconds(), 'Subtract seconds');
        self::assertSame(6, $a->subtract(1, Units::MINUTE)->minutes(), 'Subtract minutes');
        self::assertSame(5, $a->subtract(1, Units::HOUR)->hours(), 'Subtract hours');
        self::assertSame(11, $a->subtract(1, Units::DAY)->day(), 'Subtract days');
        self::assertSame(4, $a->subtract(1, Units::WEEK)->day(), 'Subtract weeks');
        self::assertSame(9, $a->subtract(1, Units::MONTH)->month(), 'Subtract months');
        self::assertSame(2010, $a->subtract(1, Units::YEAR)->year(), 'Subtract years');
        self::assertSame(2, $a->subtract(1, Units::QUARTER)->quarter(), 'Subtract quarters');
        self::assertSame(3, $a->subtract(1, Units::QUARTER)->month(), 'Subtract quarters');
    }

    public function testAddAcrossDST(): void
    {
        $a = Epoch::from(2011, 3, 12, 5, 0, 0);
        $b = Epoch::from(2011, 3, 12, 5, 0, 0);
        $c = Epoch::from(2011, 3, 12, 5, 0, 0);
        $d = Epoch::from(2011, 3, 12, 5, 0, 0);
        $e = Epoch::from(2011, 3, 12, 5, 0, 0);

        $a->add(1, Units::DAY);
        $b->add(24, Units::HOUR);
        $c->add(1, Units::MONTH);
        $e->add(1, Units::QUARTER);

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
