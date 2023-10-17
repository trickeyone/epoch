<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use DateTime;
use Epoch\Epoch;
use Epoch\Exception\DateCreationException;
use PHPUnit\Framework\TestCase;

use function chr;

class CreationTest extends TestCase
{
    public function testFrom(): void
    {
        self::assertInstanceOf(DateTime::class, Epoch::from(2010)->toDateTime());
        self::assertInstanceOf(DateTime::class, Epoch::from(2010, 1)->toDateTime());
        self::assertInstanceOf(DateTime::class, Epoch::from(2010, 1, 12)->toDateTime());
        self::assertInstanceOf(DateTime::class, Epoch::from(2010, 1, 12, 1)->toDateTime());
        self::assertInstanceOf(DateTime::class, Epoch::from(2010, 1, 12, 1, 1, 1, 1)->toDateTime());
        self::assertSame(
            Epoch::fromDateTimeInterface(new DateTime('2010-01-14T15:25:50.125'))->value(),
            Epoch::from(2010, 1, 14, 15, 25, 50, 125)->value()
        );
    }

    public function testUnixTimestamp(): void
    {
        self::assertSame(1000, Epoch::fromTimestamp(1)->value(), '1 unix timestamp == 1000');
        self::assertSame(1333129333000, Epoch::fromTimestamp(1333129333)->value());
    }

    public function testDateTimeMutation(): void
    {
        $date = new DateTime();

        self::assertNotSame($date, Epoch::fromDateTimeInterface($date)->toDateTime());
    }

    public function testInvalidTimestampThrowsException(): void
    {
        self::expectException(DateCreationException::class);
        self::expectExceptionMessage('Unable to create from timestamp');

        Epoch::fromTimestamp('dldskfngsdg9');
    }

    public function testInvalidDateStringThrowsException(): void
    {
        self::expectException(DateCreationException::class);
        self::expectExceptionMessage('Unable to parse date');

        Epoch::fromString('sdfsfdsf' . chr(0));
    }

    public function testInvalidStringThrowsException(): void
    {
        self::expectException(DateCreationException::class);
        self::expectExceptionMessage('Unable to parse date');

        Epoch::fromString('aaaaaaa');
    }
}
