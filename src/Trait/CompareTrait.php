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
    public function isAfter(null|string|DateTimeInterface|Epoch $input, Units $units = Units::MILLISECONDS): bool
    {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return false;
        }
        
        return $units === Units::MILLISECONDS
            ? $this->value() > $compare->value()
            : $this->clone()->startOf($units)->value() > $compare->value();
    }

    public function isBefore(null|string|DateTimeInterface|Epoch $input, Units $units = Units::MILLISECONDS): bool
    {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return false;
        }
        
        return $units === Units::MILLISECONDS
            ? $this->value() < $compare->value()
            : $this->clone()->endOf($units)->value() < $compare->value();
    }

    public function isBetween(
        null|string|DateTimeInterface|Epoch $from,
        null|string|DateTimeInterface|Epoch $to = null,
        Units $units = Units::MILLISECONDS
    ): bool {
        try {
            $compareFrom = self::createFrom($from);
            $compareTo = self::createFrom($to);
        } catch (DateCreationException) {
            return false;
        }

        return $this->isAfter($compareFrom, $units) && $this->isBefore($compareTo, $units);
    }

    public function isSame(null|string|DateTimeInterface|Epoch $input, Units $units = Units::MILLISECONDS): bool
    {
        try {
            $compare = self::createFrom($input);
        } catch (DateCreationException) {
            return false;
        }
        $timestamp = $compare->value();

        return $units === Units::MILLISECONDS
            ? $this->value() === $timestamp
            : (
                $this->clone()->startOf($units)->value() <= $timestamp &&
                $timestamp <= $this->clone()->endOf($units)->value()
            );
    }

    public function isSameOrAfter(null|string|DateTimeInterface|Epoch $input, Units $units = Units::MILLISECONDS): bool
    {
        return $this->isSame($input, $units) || $this->isAfter($input, $units);
    }

    public function isSameOrBefore(null|string|DateTimeInterface|Epoch $input, Units $units = Units::MILLISECONDS): bool
    {
        return $this->isSame($input, $units) || $this->isBefore($input, $units);
    }
}
