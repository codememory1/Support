<?php

namespace Codememory\Support;

use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Class Str
 * @package System\Support
 *
 * @author  Codememory
 */
class Str
{

    /**
     * @param string $str
     * @param string $separator
     *
     * @return string
     */
    public static function asPath(string $str, string $separator = '.'): string
    {

        return str_replace($separator, '/', $str);

    }

    /**
     * @param string $where
     * @param string $addStr
     *
     * @return string
     */
    public static function addToEnd(string $where, string $addStr): string
    {

        return $where . $addStr;

    }

    /**
     * @param string $where
     * @param string $addStr
     *
     * @return string
     */
    public static function addToBegin(string $where, string $addStr): string
    {

        return $addStr . $where;

    }

    /**
     * @param string       $str
     * @param array|string $find
     * @param array|string $replace
     *
     * @return bool
     */
    public static function replace(string &$str, array|string $find, array|string $replace): bool
    {

        $find = false === is_array($find) ? [$find] : $find;
        $replace = false === is_array($replace) ? [$replace] : $replace;

        foreach ($find as $index => $item) {
            $replaceKey = array_key_exists($index, $replace) ? $index : array_key_last($replace);

            $str = str_replace($item, $replace[$replaceKey], $str);
        }

        return true;

    }

    /**
     * @param array|string $str
     * @param array|string $with
     *
     * @return bool
     */
    public static function starts(array|string $str, array|string $with): bool
    {

        return self::handlerStarsOrEnds($str, $with, 'str_starts_with');

    }

    /**
     * @param array|string $str
     * @param array|string $with
     *
     * @return bool
     */
    public static function ends(array|string $str, array|string $with): bool
    {

        return self::handlerStarsOrEnds($str, $with, 'str_ends_with');

    }

    /**
     * @param string       $str
     * @param string|array $part
     * @param bool         $registerAccounting
     *
     * @return bool
     */
    public static function contains(string $str, string|array $part, bool $registerAccounting = true): bool
    {

        $regex = '/%s/';

        if (false === $registerAccounting) {
            $regex = self::addToEnd($regex, 'i');
        }

        $part = is_array($part) ? $part : [$part];

        foreach ($part as $item) {
            if (preg_match(sprintf($regex, $item), $str)) {
                return true;
            }
        }

        return false;

    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function toUppercase(string $str): string
    {

        return mb_strtoupper($str);

    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function toLowercase(string $str): string
    {

        return mb_strtolower($str);

    }

    /**
     * @param string $str
     * @param string $word
     * @param int    $offset
     * @param bool   $registerAccounting
     *
     * @return int|bool
     */
    #[Pure] public static function lastIndexOf(string $str, string $word, int $offset = 0, bool $registerAccounting = true): int|bool
    {

        if ($registerAccounting) {
            return strripos($str, $word, $offset);
        }

        return strrpos($str, $word, $offset);

    }

    /**
     * @param string $str
     * @param int    $repetitions
     *
     * @return string
     */
    #[Pure] public static function repeat(string $str, int $repetitions = 1): string
    {

        return str_repeat($str, $repetitions);

    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function camelCase(string $str): string
    {

        return self::handlerCase($str, function (string $item, int $index) {
            if ($index === 0) {
                return lcfirst($item);
            }

            return ucfirst($item);
        });

    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function studlyCase(string $str): string
    {

        return self::handlerCase($str, function (string $item) {
            return ucfirst($item);
        });

    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function snakeCase(string $str): string
    {

        $str = self::handlerCase($str, function (string $item) {
            return lcfirst($item) . '_';
        });

        return substr($str, 0, -1);

    }

    /**
     * @param string      $str
     * @param string|null $encoding
     *
     * @return bool|int
     */
    public static function length(string $str, ?string $encoding = null): bool|int
    {
        if ($encoding) {
            return mb_strlen($str, $encoding);
        }

        return mb_strlen($str);
    }

    /**
     * @param int $length
     *
     * @return string
     * @throws Exception
     */
    public static function random(int $length = 32): string
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * @param string      $str
     * @param int         $before
     * @param string|null $finish
     *
     * @return string|null
     */
    #[Pure] public static function cut(string $str, int $before, ?string $finish = null): ?string
    {

        $before = $before < 0 ? 0 : $before;
        $chars = str_split($str);
        $str = null;

        for ($i = 0; $i < $before; $i++) {
            $str .= $chars[$i];
        }

        return $str . $finish;

    }

    /**
     * @param string $str
     * @param string $symbol
     * @param bool   $firstOccurrence
     *
     * @return string
     */
    public static function trimToSymbol(string $str, string $symbol, bool $firstOccurrence = true): string
    {

        $position = $firstOccurrence ? mb_strpos($str, $symbol) : mb_strrpos($str, $symbol);
        
        return self::trimmingResultHandler(mb_substr($str, $position + 1), $str);

    }

    /**
     * @param string $str
     * @param string $symbol
     * @param bool   $firstOccurrence
     *
     * @return string
     */
    public static function trimAfterSymbol(string $str, string $symbol, bool $firstOccurrence = true): string
    {

        $position = $firstOccurrence ? mb_strpos($str, $symbol) : mb_strrpos($str, $symbol);

        return self::trimmingResultHandler(mb_substr($str, 0, $position), $str);

    }

    /**
     * @param string   $str
     * @param int      $limit
     * @param callable $handler
     *
     * @return mixed
     */
    public static function whenLimit(string $str, int $limit, callable $handler): mixed
    {

        if (self::length($str) > $limit) {
            $str = call_user_func_array($handler, [&$str, $limit]);
        }

        return $str;

    }

    /**
     * @param array|string $str
     * @param array|string $with
     * @param string       $function
     *
     * @return bool
     */
    private static function handlerStarsOrEnds(array|string $str, array|string $with, string $function): bool
    {

        $with = false === is_array($with) ? [$with] : $with;

        foreach ($with as $item) {
            if ($function($str, $item)) {
                return true;
            }
        }

        return false;

    }

    /**
     * @param string   $str
     * @param callable $handler
     *
     * @return string|null
     */
    private static function handlerCase(string $str, callable $handler): ?string
    {

        self::replace($str, [' ', '_'], '-');

        $arrayStr = explode('-', $str);
        $readyStr = null;

        foreach ($arrayStr as $index => $item) {
            if (false === empty($item)) {
                $readyStr .= call_user_func($handler, $item, $index);
            }
        }

        return $readyStr;

    }

    /**
     * @param string|null $substr
     * @param string      $str
     *
     * @return string
     */
    private static function trimmingResultHandler(?string $substr, string $str): string
    {

        return empty($substr) ? $str : $substr;

    }

}