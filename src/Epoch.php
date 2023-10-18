<?php

declare(strict_types=1);

namespace Epoch;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Epoch\Exception\DateCreationException;
use Exception;

use ValueError;

use function date_default_timezone_get;
use function is_int;
use function is_string;
use function sprintf;

final class Epoch
{
    use Trait\GetSetTrait;
    use Trait\OffsetTrait;
    use Trait\TimezoneTrait;
    use Trait\CompareTrait;
    use Trait\StartEndOfTrait;
    use Trait\AddSubtractTrait;
    use Trait\DiffTrait;

    private DateTime $date;

    private function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @param DateTimeZone|null $timeZone Defaults to PHP Default Timezone
     */
    public static function create(Epoch $source = null, DateTimeZone $timeZone = null): Epoch
    {
        $date = $source ? $source->toDateTime() : new DateTime();

        return new self(($date)->setTimezone($timeZone ?? self::getDefaultTimezone()));
    }

    public static function fromDateTimeInterface(DateTimeInterface $date): Epoch
    {
        return new self(DateTime::createFromInterface($date));
    }

    /**
     * @param int|string $timestamp Unix Timestamp in seconds
     * @param DateTimeZone|null $timeZone Defaults to PHP Default Timezone
     * @throws DateCreationException
     */
    public static function fromTimestamp(int|string $timestamp, DateTimeZone $timeZone = null): Epoch
    {
        try {
            return self::fromDateTimeInterface(
                (new DateTime('@' . $timestamp))->setTimezone(
                    $timeZone ?? self::getDefaultTimezone()
                )
            );
        } catch (Exception) {
            throw new DateCreationException('Unable to create from timestamp', DateTime::getLastErrors());
        }
    }

    /**
     * @param int $year
     * @param int|null $month Defaults to January
     * @param int|null $day Defaults to first day of month
     * @param int|null $hours Defaults to 0
     * @param int|null $minutes Defaults to 0
     * @param int|null $seconds Defaults to 0
     * @param int|null $milliseconds Defaults to 0
     * @param DateTimeZone|null $timeZone Defaults to PHP Default Timezone
     * @return Epoch
     * @throws DateCreationException
     */
    public static function from( // NOSONAR
        int $year,
        int $month = null,
        int $day = null,
        int $hours = null,
        int $minutes = null,
        int $seconds = null,
        int $milliseconds = null,
        DateTimeZone $timeZone = null
    ): Epoch {
        return self::fromString(
            sprintf(
                '%d-%02d-%02d %02d:%02d:%02d.%03d',
                $year,
                $month ?? 1,
                $day ?? 1,
                $hours ?? 0,
                $minutes ?? 0,
                $seconds ?? 0,
                $milliseconds ?? 0
            ),
            'Y-m-d H:i:s.v',
            $timeZone
        );
    }

    /**
     * @param string $dateString Date string
     * @param string $format Date-string format
     * @param DateTimeZone|null $timeZone Defaults to PHP Default Timezone
     * @return Epoch
     * @throws DateCreationException
     */
    public static function fromString(
        string $dateString,
        string $format = DateTimeInterface::ATOM,
        ?DateTimeZone $timeZone = null
    ): Epoch {
        try {
            $date = DateTime::createFromFormat($format, $dateString, $timeZone ?? self::getDefaultTimezone());
        } catch (Exception | ValueError) {
            throw new DateCreationException('Unable to parse date', DateTime::getLastErrors() ?: []);
        }
        if ($date === false) {
            throw new DateCreationException('Unable to parse date', DateTime::getLastErrors());
        }

        return self::fromDateTimeInterface($date);
    }

    public function clone(): Epoch
    {
        return clone $this;
    }

    public function __clone(): void
    {
        $this->date = DateTime::createFromInterface($this->date);
    }

    /**
     * Returns date formatted according to given format.
     * @param string $format
     * @return string
     * @link https://php.net/manual/en/datetime.format.php
     */
    public function format(string $format): string
    {
        return $this->date->format($format);
    }

    public function toDateTime(): DateTime
    {
        return DateTime::createFromInterface($this->date);
    }

    public function __toString(): string
    {
        return $this->format(DateTimeInterface::ATOM);
    }

    /**
     * @param null|string|int|DateTimeInterface|Epoch $date
     * @param string|null $format
     * @param DateTimeZone|null $timeZone
     * @return Epoch
     * @throws DateCreationException
     */
    private static function createFrom( // NOSONAR
        null|string|int|DateTimeInterface|Epoch $date,
        ?string $format = null,
        ?DateTimeZone $timeZone = null
    ): Epoch {
        if (is_string($date)) {
            $date = self::fromString($date, $format ?: DateTimeInterface::ATOM, $timeZone);
        } elseif (is_int($date)) {
            $date = self::fromTimestamp($date, $timeZone);
        } elseif ($date instanceof DateTimeInterface) {
            $date = self::fromDateTimeInterface($date);
        }

        return clone $date;
    }

    private static function getDefaultTimezone(): DateTimeZone
    {
        return new DateTimeZone(date_default_timezone_get());
    }
}
