<?php

declare(strict_types=1);

namespace Epoch;

/** @internal */
interface DateTimeFormats
{
    public const FULL_YEAR        = 'Y';
    public const MONTH            = 'n';
    public const DAY              = 'j';
    public const WEEKDAY          = 'w';
    public const ISO_WEEKDAY      = 'N';
    public const HOURS            = 'G';
    public const MINUTES          = 'i';
    public const SECONDS          = 's';
    public const TIMESTAMP        = 'U';
    public const MICROSECONDS     = 'u';
    public const MILLISECONDS     = 'v';
    public const UTC_OFFSET       = 'Z';
    public const DAY_NUMBER_YEAR  = 'z';
    public const WEEK_NUMBER_YEAR = 'W';
    public const ISO_WEEK_NUMBER  = 'o';
    public const TIMEZONE_ABBR    = 'T';
    public const TIMEZONE_NAME    = 'e';
    public const TIMEZONE_DST     = 'I';
}
