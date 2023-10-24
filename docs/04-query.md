Query
=====

## Is Before
```php
\Epoch\Epoch::isBefore(
  string|DateTimeInterface|Epoch $input,
  \Epoch\Units $units = \Epoch\Units::MILLISECONDS
): bool
```

Checks if one date is before another.

| Parameter | Description                                                                                                                  |
|-----------|------------------------------------------------------------------------------------------------------------------------------|
| `$input`  | Either a ISO-formatted date-string, `DateTimeInterface`, or a `Epoch` instance                                               |
| `$units`  | Optional. This granularity determines the precision, not just a single value check. Defaults to `\Epoch\Units::MILLISECONDS` |

If you want to limit the granularity to a unit of time other than milliseconds, pass
`\Epoch\Units` as the second parameter.
```php
\Epoch\Epoch::from(2010, 10, 20)->isBefore(
  \Epoch\Epoch::from(2010, 12, 31),
  \Epoch\Units::YEARS
); // false
\Epoch\Epoch::from(2010, 10, 20)->isBefore(
  \Epoch\Epoch::from(2011, 1, 1),
  \Epoch\Units::YEARS
); // true
```

## Is Same
```php
\Epoch\Epoch::isSame(
  string|DateTimeInterface|Epoch $input,
  \Epoch\Units $units = \Epoch\Units::MILLISECONDS
): bool
```

Checks if a date is the same as another.

| Parameter | Description                                                                                                                  |
|-----------|------------------------------------------------------------------------------------------------------------------------------|
| `$input`  | Either a ISO-formatted date-string, `DateTimeInterface`, or a `Epoch` instance                                               |
| `$units`  | Optional. This granularity determines the precision, not just a single value check. Defaults to `\Epoch\Units::MILLISECONDS` |

If you want to limit the granularity to a unit of time other than milliseconds, pass
`\Epoch\Units` as the second parameter.
```php
\Epoch\Epoch::from(2010, 10, 20)
  ->isSame(\Epoch\Epoch::from(2009, 12, 31), \Epoch\Units::YEARS); // false
\Epoch\Epoch::from(2010, 10, 20)
  ->isSame(\Epoch\Epoch::from(2010, 1, 1), \Epoch\Units::YEARS);   // true
\Epoch\Epoch::from(2010, 10, 20)
  ->isSame(\Epoch\Epoch::from(2010, 12, 31), \Epoch\Units::YEARS); // true
\Epoch\Epoch::from(2010, 10, 20)
  ->isSame(\Epoch\Epoch::from(2011, 1, 1), \Epoch\Units::YEARS);   // false
```

## Is After
```php
\Epoch\Epoch::isAfter(
  string|DateTimeInterface|Epoch $input,
  \Epoch\Units $units = \Epoch\Units::MILLISECONDS
): bool
```

Checks if a date is after another.

| Parameter | Description                                                                                                                  |
|-----------|------------------------------------------------------------------------------------------------------------------------------|
| `$input`  | Either a ISO-formatted date-string, `DateTimeInterface`, or a `Epoch` instance                                               |
| `$units`  | Optional. This granularity determines the precision, not just a single value check. Defaults to `\Epoch\Units::MILLISECONDS` |

If you want to limit the granularity to a unit of time other than milliseconds, pass
`\Epoch\Units` as the second parameter.
```php
\Epoch\Epoch::from(2010, 10, 20)
  ->isAfter(\Epoch\Epoch::from(2010, 1, 1), \Epoch\Units::YEARS);   // false
\Epoch\Epoch::from(2010, 10, 20)
  ->isAfter(\Epoch\Epoch::from(2009, 12, 31), \Epoch\Units::YEARS); // true
```

## Is Same or Before
```php
\Epoch\Epoch::isSameOrBefore(
  string|DateTimeInterface|Epoch $input,
  \Epoch\Units $units = \Epoch\Units::MILLISECONDS
): bool
```

Checks id a date is before or the same as another.

| Parameter | Description                                                                                                                  |
|-----------|------------------------------------------------------------------------------------------------------------------------------|
| `$input`  | Either a ISO-formatted date-string, `DateTimeInterface`, or a `Epoch` instance                                               |
| `$units`  | Optional. This granularity determines the precision, not just a single value check. Defaults to `\Epoch\Units::MILLISECONDS` |

If you want to limit the granularity to a unit of time other than milliseconds, pass
`\Epoch\Units` as the second parameter.
```php
\Epoch\Epoch::from(2010, 10, 20)
  ->isSameOrBefore(\Epoch\Epoch::from(2009, 12, 31), \Epoch\Units::YEARS); // false
\Epoch\Epoch::from(2010, 10, 20)
  ->isSameOrBefore(\Epoch\Epoch::from(2010, 12, 31), \Epoch\Units::YEARS); // true
\Epoch\Epoch::from(2010, 10, 20)
  ->isSameOrBefore(\Epoch\Epoch::from(2011, 1, 1), \Epoch\Units::YEARS);   // true
```

## Is Same or After
```php
\Epoch\Epoch::isSameOrAfter(
  string|DateTimeInterface|Epoch $input,
  \Epoch\Units $units = \Epoch\Units::MILLISECONDS
): bool
```

Checks id a date is after or the same as another.

| Parameter | Description                                                                                                                  |
|-----------|------------------------------------------------------------------------------------------------------------------------------|
| `$input`  | Either a ISO-formatted date-string, `DateTimeInterface`, or a `Epoch` instance                                               |
| `$units`  | Optional. This granularity determines the precision, not just a single value check. Defaults to `\Epoch\Units::MILLISECONDS` |

If you want to limit the granularity to a unit of time other than milliseconds, pass
`\Epoch\Units` as the second parameter.
```php
\Epoch\Epoch::from(2010, 10, 20)
  ->isSameOrAfter(\Epoch\Epoch::from(2011, 12, 31), \Epoch\Units::YEARS); // false
\Epoch\Epoch::from(2010, 10, 20)
  ->isSameOrAfter(\Epoch\Epoch::from(2010, 1, 1), \Epoch\Units::YEARS);   // true
\Epoch\Epoch::from(2010, 10, 20)
  ->isSameOrAfter(\Epoch\Epoch::from(2009, 12, 31), \Epoch\Units::YEARS); // true
```

## Is Between
```php
\Epoch\Epoch::isBetween(
  null|string|DateTimeInterface|Epoch $from,
  null|string|DateTimeInterface|Epoch $to,
  \Epoch\Units $units = \Epoch\Units::MILLISECONDS
): bool
```

Checks if a date is between two other dates, optionally looking at a unit of time.

| Parameter | Description                                                                                                                  |
|-----------|------------------------------------------------------------------------------------------------------------------------------|
| `$from`   | The lower bound to check against.                                                                                            |
| `$to`     | The upper bound to check against. Defaults to `null`                                                                         |
| `$units`  | Optional. This granularity determines the precision, not just a single value check. Defaults to `\Epoch\Units::MILLISECONDS` |

For both the `$from` and `$to`, if `null` is passed, it will be treated as "now".
```php
\Epoch\Epoch::from(2010, 10, 20)
  ->isBetween(
    \Epoch\Epoch::from(2010, 10, 19),
    \Epoch\Epoch::from(2010, 10, 25)
  ); // true
\Epoch\Epoch::from(2010, 10, 20)
  ->isBetween(
    \Epoch\Epoch::from(2010, 10, 25),
    \Epoch\Epoch::from(2010, 10, 19)
  ); // false
```

This check does treat the `$from` and `$to` bounds as exclusive, meaning that if the source date
and the bound are the same, the result will be `false`.
```php
\Epoch\Epoch::from(2010, 10, 20)         // 2010-10-20 00:00:00
  ->isBetween(
    \Epoch\Epoch::from(2010, 10, 20),    // 2010-10-20 00:00:00
    \Epoch\Epoch::from(2010, 10, 25)     // 2010-10-25 00:00:00
  ); // false
\Epoch\Epoch::from(2010, 10, 20, 12)     // 2010-10-20 12:00:00
  ->isBetween(
    \Epoch\Epoch::from(2010, 10, 20, 5), // 2010-10-20 05:00:00
    \Epoch\Epoch::from(2010, 10, 25)     // 2010-10-25 00:00:00
  ); // true
```

## Is Daylight Saving Time
```php
\Epoch\Epoch::isDST(): bool
```

Checks if the current date is in daylight saving time.

This uses the built-in PHP `DateTime` logic to determine DST.
```php
\Epoch\Epoch::from(2011, 3, 12)->isDST(); // false, March 12, 2011 is not DST
\Epoch\Epoch::from(2011, 3, 14)->isDST(); // true, March 14, 2011 is DST
```

## Is Lear Year
```php
\Epoch\Epoch::isLeapYear(): bool
```

Checks if the current year is a leap year.
