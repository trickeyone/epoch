Epoch
=====

[![PHPUnit](https://github.com/trickeyone/epoch/actions/workflows/unit-tests.yml/badge.svg)](https://github.com/trickeyone/epoch/actions/workflows/unit-tests.yml)
![code coverage badge](https://raw.githubusercontent.com/trickeyone/epoch/gh-images/coverage.svg)
[![Test Coverage](https://codeclimate.com/github/trickeyone/epoch/badges/coverage.svg)](https://codeclimate.com/github/trickeyone/epoch/coverage)
[![Code Climate](https://codeclimate.com/github/trickeyone/epoch/badges/gpa.svg)](https://codeclimate.com/github/trickeyone/epoch)

## Installation
```shell
$ composer require trickeyone/epoch
```

## Usage
- [Creation](docs/creation/01-creation.md)
  - [Now](docs/creation/01-creation.md#now)
  - [Create from `DateTimeInterface`](docs/creation/01-creation.md#datetimeinterface)
  - [String + Format](docs/creation/01-creation.md#strings)
  - [Unix Timestamp](docs/creation/01-creation.md#unix-timestamp)
  - [Create from year, month, day, etc.](docs/creation/03-specific-values.md)
  - [Cloning](docs/creation/01-creation.md#cloning)
- [Get/Set](docs/01-get-set.md)
  - [Microseconds](docs/01-get-set.md#microseconds)
  - [Milliseconds](docs/01-get-set.md#milliseconds)
  - [Seconds](docs/01-get-set.md#seconds)
  - [Minutes](docs/01-get-set.md#minutes)
  - [Hours](docs/01-get-set.md#hours)
  - [Day of the Month](docs/01-get-set.md#day-of-the-month)
  - [Day of the Week](docs/01-get-set.md#day-of-the-week)
  - [ISO Day of the Week](docs/01-get-set.md#iso-day-of-the-week)
  - [Day of the Year](docs/01-get-set.md#day-of-the-year)
  - [Week of the Year](docs/01-get-set.md#week-of-the-year)
  - [Month](docs/01-get-set.md#month)
  - [Quarter](docs/01-get-set.md#quarter)
  - [Year](docs/01-get-set.md#year)
  - [UTC Offset](docs/01-get-set.md#utc-offset)
  - [Timezone](docs/01-get-set.md#timezone)
  - [Timezone Abbreviation](docs/01-get-set.md#timezone-abbreviation)
  - [Timezone Name](docs/01-get-set.md#timezone-name)
- [Manipulate](docs/02-manipulate.md)
  - [Add Time](docs/02-manipulate.md#add)
  - [Subtract Time](docs/02-manipulate.md#subtract)
  - [Start of Time](docs/02-manipulate.md#start-of-time)
  - [End of Time](docs/02-manipulate.md#end-of-time)
- [Display](docs/03-display.md)
  - [Format](docs/03-display.md#format)
  - [Stringable](docs/03-display.md#string)
  - [Difference](docs/03-display.md#difference)
  - [Timestamp (in seconds)](docs/03-display.md#timestamp-in-seconds)
  - [Timestamp (in milliseconds)](docs/03-display.md#timestamp-in-milliseconds)
  - [Days In Month](docs/03-display.md#days-in-month)
  - [As `DateTime`](docs/03-display.md#as-datetime)
- [Query](docs/04-query.md)
  - [Is Before](docs/04-query.md#is-before)
  - [Is Same](docs/04-query.md#is-same)
  - [Is After](docs/04-query.md#is-after)
  - [Is Same or Before](docs/04-query.md#is-same-or-before)
  - [Is Same or After](docs/04-query.md#is-same-or-after)
  - [Is Between](docs/04-query.md#is-between)
  - [Is Daylight Saving Time](docs/04-query.md#is-daylight-saving-time)
  - [Is Leap Year](docs/04-query.md#is-lear-year)

Requirements
-----------
* PHP 8+

Resources
---------

* [Report issues](https://github.com/trickeyone/epoch/issues) and
  [Send Pull Requests](https://github.com/trickeyone/epoch/pulls)
