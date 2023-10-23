String + Format
===============

Create a new instance from a string and the provided date-time format. The date-time format is 
required to properly parse the date-time string.

```php
\Epoch\Epoch::fromString(string $dateString, string $format = \DateTimeInterface::ATOM, ?\DateTimeZone $timeZone): \Epoch\Epoch
```

| Parameter     |                                                                                                                                                                                                                                                                                  |
|---------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$dateString` | Date-time string<br>Type: `string`                                                                                                                                                                                                                                               |
| `$format`     | Date-time format used to parse `$dateString`. Defaults to `DateTimeInterface::ATOM`<br>Type: `string`<br>See DateTime [format](https://www.php.net/manual/en/datetimeimmutable.createfromformat.php#datetimeimmutable.createfromformat.parameters) for acceptable values to use. |
| `$timeZone`   | Optional. Timezone to use for the date. See [Time Zones](01-creation.md#time-zones) for information.                                                                                                                                                                             |


By default, the `DateTimeInterace::ATOM` format will be used.
```php
$epoch = \Epoch\Epoch::fromString('2023-03-31T13:24:56Z');
```

Otherwise you can provide any format that is supposed by `DateTime::createFromFormat()`.
```php
$epoch = \Epoch\Epoch::fromString('12-25-1995', 'm-d-Y');
$epoch = \Epoch\Epoch::fromString('19951225', 'Ymd');
$epoch = \Epoch\Epoch::fromString('24/12/2019 09:15:00', 'd/m/Y H:i:s');
```

If an invalid date and/or format are provided, then a `DateCreationException` is thrown.
