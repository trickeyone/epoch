<?php

declare(strict_types=1);

namespace Epoch\Test\Epoch;

use Epoch\Epoch;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testFormatToString(): void
    {
        $dateString = '2012-10-31T15:00:00+00:00';

        self::assertSame(
            $dateString,
            (string)Epoch::fromString($dateString)
        );
        self::assertSame(
            '2012 Oct 31 3:00:00PM',
            Epoch::fromString($dateString)->format('Y M d g:i:sA')
        );
    }
}
