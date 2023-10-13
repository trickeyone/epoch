<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateTimeInterface;
use Epoch\Epoch;
use Epoch\Exception\DateCreationException;
use Epoch\Units;

/** @internal */
trait CompareTrait
{
    public function isAfter(string|DateTimeInterface|Epoch $input, string $units = Units::MILLISECOND): bool
    {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return false;
        }
        
        return $units === Units::MILLISECOND
            ? $this->value() > $compare->value()
            : $this->clone()->startOf($units)->value() > $compare->value();
    }

    public function isBefore(string|DateTimeInterface|Epoch $input, string $units = Units::MILLISECOND): bool
    {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return false;
        }
        
        return $units === Units::MILLISECOND
            ? $this->value() < $compare->value()
            : $this->clone()->endOf($units)->value() < $compare->value();
    }

    public function isBetween(
        null|string|DateTimeInterface|Epoch $from,
        null|string|DateTimeInterface|Epoch $to,
        string $units = Units::MILLISECOND
    ): bool {
        try {
            $compareFrom = self::createFrom($from);
            $compareTo = self::createFrom($to);
        } catch (DateCreationException) {
            return false;
        }

        return !$this->isBefore($compareFrom, $units) && !$this->isAfter($compareTo, $units);
    }

    public function isSame(string|DateTimeInterface|Epoch $input, string $units = Units::MILLISECOND): bool
    {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return false;
        }
        $timestamp = $compare->value();

        return $units === Units::MILLISECOND
            ? $this->value() === $timestamp
            : (
                $this->clone()->startOf($units)->value() <= $timestamp &&
                $timestamp <= $this->clone()->endOf($units)->value()
            );
    }

    public function isSameOrAfter(string|DateTimeInterface|Epoch $input, string $units = Units::MILLISECOND): bool
    {
        return $this->isSame($input, $units) || $this->isAfter($input, $units);
    }

    public function isSameOrBefore(string|DateTimeInterface|Epoch $input, string $units = Units::MILLISECOND): bool
    {
        return $this->isSame($input, $units) || $this->isBefore($input, $units);
    }
}
