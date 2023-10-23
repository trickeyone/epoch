Get + Set
=========

All setter methods are fluent.
```php
\Epoch\Epoch::create()->setMinutes(integer)->minutes(); // returns the value passed to setMinutes()
```

## Microseconds
```php
\Epoch\Epoch::create()->microseconds(); // integer
\Epoch\Epoch::create()->setMicroseconds(integer);
```

Get or set the milliseconds.

Accepts an integer from 0 to 999999. If the range is exceeded, it is limited to the max value of 999999.

## Milliseconds
```php
\Epoch\Epoch::create()->milliseconds(); // integer
\Epoch\Epoch::create()->setMilliseconds(integer);
```

Get or set the milliseconds.

Accepts an integer from 0 to 999. If the range is exceeded, it is limited to the max value of 999.

## Seconds
```php
\Epoch\Epoch::create()->seconds(); // integer
\Epoch\Epoch::create()->setSeconds(integer);
```

Get or set the seconds.

Accepts an integer from 0 to 59. If the range is exceeded, it is limited to the max value of 59.

## Minutes
```php
\Epoch\Epoch::create()->minutes(); // integer
\Epoch\Epoch::create()->setMinutes(integer);
```

Get or set the minutes.

Accepts an integer from 0 to 59. If the range is exceeded, it is limited to the max value of 59.

## Hours
```php
\Epoch\Epoch::create()->hours(); // integer
\Epoch\Epoch::create()->setHours(integer);
```

Get or set the hours;

Accepts an integer from 0 to 23. If the range is exceeded, it is limited to the max value of 23.

## Day of the Month
```php
\Epoch\Epoch::create()->day(); // integer
\Epoch\Epoch::create()->setDay(integer);
```

Get or set the day of the month.

Accepts an integer from 1 to 31. If the range is exceeded, it is limited to the max number of days in the month.

**Note:** If you chain multiple actions to construct a date, you should start from a year, then month,
then day, etc. If done otherwise, you may encounter unexpected results. i.e. If the day is first
set to 31, then month set to a month that has less than 31 days, the date will bubble over into the
next month (see [month](#month) for more details).

## Day of the Week
```php
\Epoch\Epoch::create()->weekday(); // integer
\Epoch\Epoch::create()->setWeekday(integer);
```

Get or set the day of the week.

Accepts an integer from 0 to 6 (Sunday is 0 and Saturday is 6).

If the value given is from 0-6, the weekday will remain in the current week.

If the value exceeds the range, it will bubble to another week.
```php
\Epoch\Epoch::create()->setWeekday(-7); // last Sunday
\Epoch\Epoch::create()->setWeekday(0); // this Sunday
\Epoch\Epoch::create()->setWeekday(7); // next Sunday
\Epoch\Epoch::create()->setWeekday(10); // next Wednesday
```

## ISO Day of the Week
```php
\Epoch\Epoch::create()->isoWeekday(); // integer
\Epoch\Epoch::create()->setIsoWeekday(integer);
```

Get or set the [ISO day of the week](https://en.wikipedia.org/wiki/ISO_week_date) with 1 being Monday and 7 being Sunday.

As with [Day of Week](#day-of-week), if the value exceeds the range, it will bubble to another week.

## Day of the Year
```php
\Epoch\Epoch::create()->dayOfYear(); // integer
```

Gets the day of the year (1-366).

## Week of the Year
```php
\Epoch\Epoch::create()->weekOfYear(); // integer
```

Gets the [ISO week of the year](https://en.wikipedia.org/wiki/ISO_week_date).

## Month
```php
\Epoch\Epoch::create()->month(); // integer
\Epoch\Epoch::create()->setMonth(integer);
```

Get or set the month.

Accepts an integer from 1 to 12. If the value exceeds the range, it will bubble to the year.

If the month is changed and the new month does not have enough days to keep the current day of
the month, it will bubble to the next month.

## Quarter
```php
\Epoch\Epoch::create()->quarter(); // integer
\Epoch\Epoch::create()->setQuarter(integer);
```

Get or set the quarter (1 to 4).

When setting the quarter, if the value exceeds the bound, it will be forced to the min/max of the bounds.
i.e.
```php
\Epoch\Epoch::fromString('2013-01-01T00:00:00.000')->setQuarter(-1); // Quarter will be 1
\Epoch\Epoch::fromString('2013-06-01T00:00:00.000')->setQuarter(-1); // Quarter will be 1
\Epoch\Epoch::fromString('2013-06-01T00:00:00.000')->setQuarter(5); // Quarter will be 4
```

## Year
```php
\Epoch\Epoch::create()->year(); // integer
\Epoch\Epoch::create()->setYear(integer);
```

Get or set the year.

Accepts integers from `-PHP_INT_MAX` to `PHP_INT_MAX`
