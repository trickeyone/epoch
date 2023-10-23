Creation
========

## Now
```php
$epoch = \Epoch\Epoch::create(); // Create an instance for the current date/time (aka "now")
```

## `DateTimeInterface`
Create from `DateTimeInterface` object. The provided date object is not affected by any operations executed.
```php
$myDate = new DateTime('2023-03-31T13:24:56Z');
$epoch = \Epoch\Epoch::fromDateTimeInterface($myDate);
```

## Strings
Create from string and date-time format.
```php
$epoch = \Epoch\Epoch::fromString('2023-03-31T13:24:56Z'); // Create from default ATOM date-time format
$epoch = \Epoch\Epoch::fromString('March 31, 2023', 'F j, Y'); // Create from provided date-time format
```

## Unix Timestamp
Create from Unix timestamp.
```php
$epoch = \Epoch\Epoch::fromTimestamp(1680269096);
```

## Specific Values
Create from specific values (i.e. year, month, day, hour, etc.).
```php
$epoch = \Epoch\Epoch::from(2023);
echo (string)$epoch; // Echos "2023-01-01T00:00:00+00:00"
$epoch = \Epoch\Epoch::from(2023, 3, 31);
echo (string)$epoch; // Echos "2023-03-31T00:00:00+00:00"
```
