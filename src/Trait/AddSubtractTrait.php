<?php

/** @noinspection PhpDuplicateSwitchCaseBodyInspection */

declare(strict_types=1);

namespace Epoch\Trait;

use DateInterval;
use Epoch\Duration;
use Epoch\Epoch;
use Epoch\Units;

use function abs;
use function is_int;

trait AddSubtractTrait
{
    public function add(DateInterval|int|float $amount, Units $units = Units::MILLISECONDS): Epoch
    {
        if (is_int($amount) && $amount < 0) {
            return $this->subtract(abs($amount), $units);
        } else {
            $duration = new Duration($amount, $units);
            $this->date->add($duration->toDateInterval());
        }

        return $this;
    }

    public function subtract(DateInterval|int|float $amount, Units $units = Units::MILLISECONDS): Epoch
    {
        $duration = new Duration($amount, $units);
        $this->date->sub($duration->toDateInterval());

        return $this;
    }
}
