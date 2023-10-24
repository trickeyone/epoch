Creation
========

### Time Zones
All creation methods that accept a `DateTimeZone` parameter, default to the system/PHP default timezone if no value is provided.

## Now
Create a fresh instance for "now". Optionally pass a `DateTimeZone` to set for the newly created instance.
```php
\Epoch\Epoch::create(?DateTimeZone $timeZone): \Epoch\Epoch
```
```php
\Epoch\Epoch::create(); // Create an instance for the current date/time (aka "now")
```

## `DateTimeInterface`
Create from `DateTimeInterface` object.
The passed object is treated as immutable and a new instance is created internally.
```php
\Epoch\Epoch::fromDateTimeInterface(DateTimeInterface $dateTime): \Epoch\Epoch
```
```php
$myDate = new DateTime('2023-03-31T13:24:56Z');
\Epoch\Epoch::fromDateTimeInterface($myDate);
```

## [Strings](02-string-format.md)
Create from string and date-time format.
```php
\Epoch\Epoch::fromString('2023-03-31T13:24:56Z'); // ATOM date-time format
\Epoch\Epoch::fromString('March 31, 2023', 'F j, Y'); // provided date-time format
```

## Unix Timestamp
Create from Unix timestamp.
```php
\Epoch\Epoch::fromTimestamp(int $timestamp, ?DateTimeZone $timeZone): \Epoch\Epoch
```
```php
\Epoch\Epoch::fromTimestamp(1680269096);
```

## [Specific Values](03-specific-values.md)
Create from specific values (i.e. year, month, day, hour, etc.).
```php
echo (string)\Epoch\Epoch::from(2023); // "2023-01-01T00:00:00+00:00"
echo (string)\Epoch\Epoch::from(2023, 3, 31); // "2023-03-31T00:00:00+00:00"
```

## Cloning
All Epochs are mutable. If you want to clone an instance, you can do so by using PHP's native `clone` keyword 
or by one of the fluent methods provided by Epoch.

```php
$original = \Epoch\Epoch::create();
$copy1 = clone $original; // creates a new instance with its own date and will not affect the original
$copy2 = $original->clone(); // uses the same methodology as the above, only allows for fluent method calls on the new instance

$original->clone()->add(1, \Epoch\Units::DAYS); // adds 1 day to the new instance, but will not affect $original
```
