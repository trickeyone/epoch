<?php

declare(strict_types=1);

namespace Epoch;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Epoch\Exception\DateCreationException;
use Exception;

use function is_string;

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

    public static function create(): Epoch
    {
        return new self(new DateTime());
    }

    public static function createFromDateTimeInterface(DateTimeInterface $date): self
    {
        return new self(DateTime::createFromInterface($date));
    }

    /**
     * @param string $date
     * @param string $format
     * @param DateTimeZone|null $timeZone
     * @return Epoch
     * @throws DateCreationException
     */
    public static function createFromString(
        string $date,
        string $format = DateTimeInterface::ATOM,
        ?DateTimeZone $timeZone = null
    ): self {
        try {
            $date = DateTime::createFromFormat($format, $date, $timeZone);
        } catch (Exception) {
            throw new DateCreationException('Unable to parse date', DateTime::getLastErrors());
        }

        return self::createFromDateTimeInterface($date);
    }

    public function clone(): Epoch
    {
        return clone $this;
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
     * @param string|DateTimeInterface|Epoch|null $date
     * @param string|null $format
     * @param DateTimeZone|null $timeZone
     * @return Epoch
     * @throws DateCreationException
     */
    private static function createFrom(
        null|string|DateTimeInterface|Epoch $date,
        ?string $format = null,
        ?DateTimeZone $timeZone = null
    ): Epoch {
        if (null === $date) {
            $date = self::create();
        } elseif (is_string($date)) {
            $date = self::createFromString($date, $format, $timeZone);
        } elseif ($date instanceof DateTimeInterface) {
            $date = self::createFromDateTimeInterface($date);
        }

        return clone $date;
    }
}
