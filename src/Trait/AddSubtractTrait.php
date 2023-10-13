<?php

declare(strict_types=1);

namespace Epoch\Trait;

use DateInterval;
use Epoch\Epoch;
use Epoch\Units;

use function sprintf;

trait AddSubtractTrait
{
    public function add(DateInterval|int $amount, string $units = Units::MILLISECOND): Epoch
    {
        if (!$amount instanceof DateInterval) {
            $amount = new DateInterval(self::getIntervalPeriod($amount, $units));
        }
        $this->date->add($amount);

        return $this;
    }

    public function subtract(DateInterval|int $amount, string $units = Units::MILLISECOND): Epoch
    {
        if (!$amount instanceof DateInterval) {
            $amount = new DateInterval(self::getIntervalPeriod($amount, $units));
        }
        $this->date->sub($amount);

        return $this;
    }

    private static function getIntervalPeriod(int $amount, string $units): string
    {
        $format = 'P';
        switch ($units) {
            case Units::YEAR:
                $value = 'Y';
                break;
            case Units::QUARTER:
                $amount *= 3; // intentional fallthrough
            case Units::MONTH:
                $value = 'M';
                break;
            case Units::WEEK:
                $value = 'W';
                break;
            case Units::DAY:
                $value = 'D';
                break;
            case Units::HOUR:
                $format .= 'T';
                $value = 'H';
                break;
            case Units::MINUTE:
                $format .= 'T';
                $value = 'M';
                break;
            case Units::SECOND:
            default:
                $format .= 'T';
                $value = 'S';
        }

        return sprintf($format . '%d%s', $amount, $value);
    }
}
