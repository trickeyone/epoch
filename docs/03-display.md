Display
=======

Convenient methods to display the date.

## Format
```php
\Epoch\Epoch::format(string $format): string;
```

Returns the date formatted in the specified format. For available format options/tokens,
see [DateTime::format](https://php.net/manual/en/datetime.format.php).

## String

Epochs can be cast as strings and will display in the `ATOM` format.
```php
print (string)\Epoch\Epoch::from(2012, 5, 13); // 2012-05-13T00:00:00-00:00
```

## Difference
```php
\Epoch\Epoch::diff(
  int|string|DateTimeInterface|Epoch $input,
  string $units = Units::MILLISECONDS,
  bool $asFloat = false
): int|float;
```

| Parameter  | Description                                                                                                                                      |
|------------|--------------------------------------------------------------------------------------------------------------------------------------------------|
| `$input`   | The target date to diff the current Epoch date against.<br>An integer, date-string, `DateTimeInterface, or another Epoch instance can be passed. |
| `$units`   | The unit of time to diff. Defaults to `\Epoch\Units::MILLISECONDS`<br>Type: `\Epoch\Units`                                                       |
| `$asFloat` | By default, the result will be returned as an integer. Passing `true` as the third parameter will return a float.                                |

```php
$a = \Epoch\Epoch::from(2008, 10);
$b = \Epoch\Epoch::from(2007, 1);
$a->diff($b, \Epoch\Units::YEARS);       // 1
$a->diff($b, \Epoch\Units::YEARS, true); // 1.75
```

If the input value is earlier than the Epoch date, the returned value will be negative.
```php
$a = \Epoch\Epoch::create();
$b = \Epoch\Epoch::create()->add(1, \Epoch\Units::SECONDS);
$a->diff($b); // -1000
$b->diff($a); //  1000
```

### Month and year diffs
The handling for month and year diffs has some optimization built-in. It is optimized to ensure
that two months with the same day are always a whole number apart.

So, Jan 15 to Feb 15 should be exactly 1 month.

Feb 28 to Mar 28 should be exactly 1 month.

Feb 28 2011 to Feb 28 2012 should be exactly 1 year.

## Timestamp (in seconds)
```php
\Epoch\Epoch::timestamp(bool $milliseconds = false): int|float;
```
By default, this will return the timestamp as a whole integer. If you wish to also get the 
milliseconds as a floating point decimal, pass `true` to the method.
```php
\Epoch\Epoch::fromTimestamp(1333129333)->timestamp():     // 1333129333
\Epoch\Epoch::fromTimestamp(1333129333)->timestamp(true): // 1333129333.000
```

## Timestamp (in milliseconds)
```php
\Epoch\Epoch::value(): int;
```
The timestamp, including milliseconds, as a whole integer.
```php
\Epoch\Epoch::fromTimestamp(1333129333)->value(); /// 1333129333000
```

## Days In Month
```php
\Epoch\Epoch::daysInMonth(): int;
```

Gets the number of days in the current month.
```php
\Epoch\Epoch::from(2012, 2)->daysInMonth(); /// 29
\Epoch\Epoch::from(2012, 1)->daysInMonth(); /// 31
```

## As `DateTime`
```php
\Epoch\Epoch::toDateTime(): DateTime;
```

Gets a copy of the date as a `DateTime` object.

This will return a copy of the `DateTime` that Epoch uses internally, so any changes to this
object will not cause adverse affects.
