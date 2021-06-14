<?php

namespace Codememory\Support;

use JetBrains\PhpStorm\Pure;

/**
 * Class Number
 * @package System\Support
 *
 * @author  Codememory
 */
class Number
{

    /**
     * @param mixed $data
     *
     * @return int
     */
    public static function parse(mixed $data): int
    {

        return (int) $data;

    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    #[Pure] public static function isInt(mixed $data): bool
    {

        return is_int($data);

    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    #[Pure] public static function isNumber(mixed $data): bool
    {

        return is_numeric($data) || is_double($data);

    }

    /**
     * @param int|float $number
     * @param int|float $from
     * @param int|float $before
     *
     * @return bool
     */
    public static function same(int|float $number, int|float $from, int|float $before): bool
    {

        return $number > $from && $number < $before;

    }

    /**
     * @param string         $str
     * @param int|float|null $specific
     *
     * @return bool
     */
    public static function thereToString(string $str, int|float|null $specific = null): bool
    {

        if (null !== $specific) {
            return preg_match(sprintf('/%s/', preg_quote($specific)), $str);
        }

        return preg_match('/[0-9]+/', $str);

    }

    /**
     * @param int|float $from
     * @param int|float $subtrahend
     *
     * @return float|int
     */
    public static function subtract(int|float $from, int|float $subtrahend): float|int
    {

        return $from - $subtrahend;

    }

    /**
     * @param int|float|array $numbers
     *
     * @return int|float
     */
    #[Pure] public static function sum(int|float|array $numbers): int|float
    {

        $numbers = is_array($numbers) ? $numbers : [$numbers];
        $sum = 0;

        foreach ($numbers as $number) {
            $sum += $number;
        }

        return $sum;

    }

    /**
     * @param int|float $number
     * @param int|float $dividend
     *
     * @return int|float
     */
    public static function division(int|float $number, int|float $dividend): int|float
    {

        return $number / $dividend;

    }

    /**
     * @param int|float $number
     * @param int|float $factor
     *
     * @return int|float
     */
    public static function multiply(int|float $number, int|float $factor): int|float
    {

        return $number * $factor;

    }

    /**
     * @param int|float $number
     * @param int       $factor
     *
     * @return float|int
     */
    public static function toDegree(int|float $number, int $factor): float|int
    {

        return $number ** $factor;

    }

    /**
     * @param int|float $number
     * @param int|float $percent
     *
     * @return float|int
     */
    #[Pure] public static function numberOfPercent(int|float $number, int|float $percent): float|int
    {

        return self::multiply(
            self::division($number, 100),
            $percent
        );

    }

    /**
     * @param int|float $number
     * @param int|float $percent
     *
     * @return float|int
     */
    #[Pure] public static function percentOfNumber(int|float $first, int|float $second): float|int
    {

        return self::multiply(
            self::division($second, $first),
            100
        );

    }

}