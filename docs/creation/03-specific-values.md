Specific Values
===============

Create a new instance from a specific values.
```php
\Epoch\Epoch::from(int $year, ?int $month, ?int $day, ?int $hours, ?int $minutes, ?int $seconds, ?float $milliseconds, ?\DateTimeZone $timeZone)
```

| Parameter       |                                                                                                                                    |
|-----------------|------------------------------------------------------------------------------------------------------------------------------------|
| `$year`         | Required. The year of the date. This is the minimum required parameter.<br>Type: `integer`                                         |
| `$month`        | Optional. The month of the date (1-12).<br>Type: `integer`                                                                         |
| `$day`          | Optional. The day of the date (Starting from 1).<br>Type: `integer`                                                                |
| `$hours`        | Optional. The hour of the date (0-23).<br>Type: `integer`                                                                          |
| `$minutes`      | Optional. The minute of the date (0-59).<br>Type: `integer`                                                                        |
| `$seconds`      | Optional. The second of the date (0-59).<br>Type: `integer`                                                                        |
| `$milliseconds` | Optional. The millisecond of the date, this does accept fractional values (0-999.999).<br>Type: `float`                            |              
| `$timeZone`     | Optional. Timezone to use for the date. See [Time Zones](01-creation.md#time-zones) for information.<br>Type: `DateTimeZone` |
