<?php

declare(strict_types=1);

namespace Epoch;

enum Units: string
{
    case YEARS        = 'years';
    case MONTHS       = 'months';
    case DAYS         = 'days';
    case HOURS        = 'hours';
    case MINUTES      = 'minutes';
    case SECONDS      = 'seconds';
    case MILLISECONDS = 'milliseconds';
    case WEEKS        = 'weeks';
    case QUARTERS     = 'quarters';
}
