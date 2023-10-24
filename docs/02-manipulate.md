Manipulate
==========

Easily manipulate a date with the convenient fluent methods provided by Epoch.

If you want to copy an instance and manipulate it, please see [cloning](creation/01-creation.md#cloning) for more information.

All manipulation methods are fluent.

## Add
```php
\Epoch\Epoch::add(DateInterval|int $amount, \Epoch\Units $units): \Epoch\Epoch;
```

Mutates the date by adding time.

| Parameter |                                                                                                     |
|-----------|-----------------------------------------------------------------------------------------------------|
| `$amount` | The amount of time to add, or a predefined `DateInterval`.<br>Type: `integer\|DateInterval`         |
| `$units`  | Optional. The unit of time to add. Defaults to `\Epoch\Units::MILLISECONDS`<br>Type: `\Epoch\Units` |

If you want to add multiple different units of time, you achieve this with chaining.
```php
\Epoch\Epoch::create()
  ->add(1, \Epoch\Units::DAYS)
  ->add(5, \Epoch\Units::MONTHS)
  ->add(3, \Epoch\Units::HOURS);
```

#### Special considerations for months and years
If the day of the original date is greater than the number of days in the manipulated date, the day of the month will 
spill over into the following month.
```php
\Epoch\Epoch::from(2010, 1, 31)   // January 31
  ->add(1, \Epoch\Units::MONTHS); // March 3
```

Fractional units are supported for all units except milliseconds.
```php
\Epoch\Epoch::fromString('2012-03-15T14:00:00-07:00') // March 15, 2012 2:00 PM CST
  ->add(1.5, \Epoch\Units::DAYS); // Adds 1 day, 12 hours. March 17, 2012 2:00 AM CST
```

Alternatively, if you have a `DateInterval`, you can pass this, and it will be used to determine the amount of time
to add.
```php
$interval = new DateInterval('P1Y2DT3H4M1S'); // Add 1 year, 2 days, 3 hours, 4 minutes, and 1 second
\Epoch\Epoch::fromString('2010-01-01T00:00:00-06:00') // January 1, 2010 00:00:00 CST
  ->add($interval); // February 2, 2011 03:04:01 CST
```

## Subtract
```php
\Epoch\Epoch::subtract(DateInterval|int $amount, \Epoch\Units $units): \Epoch\Epoch;
```

Mutates the date by subtracting time.

| Parameter |                                                                                                          |
|-----------|----------------------------------------------------------------------------------------------------------|
| `$amount` | The amount of time to subtract, or a predefined `DateInterval`.<br>Type: `integer\|DateInterval`         |
| `$units`  | Optional. The unit of time to subtract. Defaults to `\Epoch\Units::MILLISECONDS`<br>Type: `\Epoch\Units` |

The same rules as defined for `\Epoch\Epoch::add()` follow for this method.

## Start of Time
```php
\Epoch\Epoch::startOf(\Epoch\Units $units): \Epoch\Epoch;
```

Mutates the date by setting it to the start of the unit of time.

| Unit                     | Description                                                                        |
|--------------------------|------------------------------------------------------------------------------------|
| `\Epoch\Units::YEARS`    | set to January 1st, 12:00 am of this year                                          |
| `\Epoch\Units::MONTHS`   | set to the 1st of this month, 12:00 am                                             |
| `\Epoch\Units::QUARTERS` | set to the beginning of the current quarter, 1st day of the month, 12:00 am        |
| `\Epoch\Units::WEEKS`    | set to the first day of this week, 12:00 am                                        |
| `\Epoch\Units::DAYS`     | set to 12:00 am of the day                                                         |
| `\Epoch\Units::HOURS`    | set to the start of the current hour with 0 minutes, 0 seconds, and 0 milliseconds |
| `\Epoch\Units::MINUTES`  | set to the start of the current minute with 0 seconds and 0 milliseconds           |
| `\Epoch\Units::SECONDS`  | set to the start of the current second with 0 milliseconds                         |

## End of Time
```php
\Epoch\Epoch::endOf(\Epoch\Units $units): \Epoch\Epoch;
```

Mutates the date by setting it to the end of the unit of time.


| Unit                     | Description                                                                          |
|--------------------------|--------------------------------------------------------------------------------------|
| `\Epoch\Units::YEARS`    | set to December 31st, 23:59:59.999 of this year                                      |
| `\Epoch\Units::MONTHS`   | set to the last day of this month, 23:59:59.999                                      |
| `\Epoch\Units::QUARTERS` | set to the end of the current quarter, last day of the month, 23:59:59.999           |
| `\Epoch\Units::WEEKS`    | set to the last day of this week, 23:59:59.999                                       |
| `\Epoch\Units::DAYS`     | set to 23:59:59.999 of the day                                                       |
| `\Epoch\Units::HOURS`    | set to the end of the current hour with 59 minutes, 59 seconds, and 999 milliseconds |
| `\Epoch\Units::MINUTES`  | set to the end of the current minute with 59 seconds and 999 milliseconds            |
| `\Epoch\Units::SECONDS`  | set to the end of the current second with 999 milliseconds                           |
