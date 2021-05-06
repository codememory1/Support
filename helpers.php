<?php

use Codememory\Support\Arr;
use Codememory\Support\Str;
use JetBrains\PhpStorm\Pure;

if (!function_exists('arrayExistKey')) {
    /**
     * @param array  $data
     * @param string $keys
     *
     * @return bool
     */
    function arrayExistKey(array $data, string $keys): bool
    {

        return Arr::exists($data, $keys);

    }
}

if (!function_exists('arrayGetElement')) {
    /**
     * @param array  $data
     * @param string $keys
     *
     * @return mixed
     */
    function arrayGetElement(array $data, string $keys): mixed
    {

        return Arr::set($data)::get($keys);

    }
}

if (!function_exists('arraySelectElements')) {
    /**
     * @param array  $data
     * @param string ...$keys
     *
     * @return array
     */
    function arraySelectElements(array $data, string ...$keys): array
    {

        return Arr::set($data)::select(...$keys);

    }
}

if (!function_exists('arrayPull')) {
    /**
     * @param array  $data
     * @param string $key
     *
     * @return mixed
     */
    function arrayPull(array &$data, string $key): mixed
    {

        return Arr::pull($data, $key);

    }
}

if (!function_exists('arrayDot')) {
    /**
     * @param array  $data
     * @param string $separator
     *
     * @return array
     */
    function arrayDot(array $data, string $separator = '.'): array
    {

        return Arr::dot($data, $separator);

    }
}

if (!function_exists('arrayAddToPosition')) {
    /**
     * @param array $where
     * @param mixed $addedData
     * @param int   $position
     *
     * @return array
     * @throws Exception
     */
    function arrayAddToPosition(array $where, mixed $addedData, int $position): array
    {

        return Arr::addToPosition($where, $addedData, $position);

    }
}

if (!function_exists('arrayAddAfterEach')) {
    /**
     * @param array $where
     * @param mixed $insertData
     *
     * @return array
     * @throws Exception
     */
    function arrayAddAfterEach(array $where, mixed $insertData): array
    {

        return Arr::addAfterEach($where, $insertData);

    }
}

if (!function_exists('arrayAddBeforeEach')) {
    /**
     * @param array $where
     * @param mixed $insertData
     *
     * @return array
     * @throws Exception
     */
    function arrayAddBeforeEach(array $where, mixed $insertData): array
    {

        return Arr::addBeforeEach($where, $insertData);

    }
}

if (!function_exists('arrayMerge')) {
    /**
     * @param array $data
     * @param       ...$arrays
     *
     * @return array
     */
    function arrayMerge(array &$data, ...$arrays): array
    {

        return Arr::merge($data, ...$arrays);

    }
}

if (!function_exists('stringAsPath')) {
    /**
     * @param string $str
     * @param string $separator
     *
     * @return string
     */
    function stringAsPath(string $str, string $separator = '.'): string
    {

        return Str::asPath($str, $separator);

    }
}

if (!function_exists('stringReplace')) {
    /**
     * @param string       $str
     * @param array|string $find
     * @param array|string $replace
     *
     * @return bool
     */
    function stringReplace(string &$str, array|string $find, array|string $replace): bool
    {

        return Str::replace($str, $find, $replace);

    }
}

if (!function_exists('stringContains')) {
    /**
     * @param string       $str
     * @param string|array $part
     * @param bool         $registerAccounting
     *
     * @return bool
     */
    function stringContains(string $str, string|array $part, bool $registerAccounting = true): bool
    {

        return Str::contains($str, $part, $registerAccounting);

    }
}

if (!function_exists('stringToUppercase')) {
    /**
     * @param string $str
     *
     * @return string
     */
    #[Pure]
    function stringToUppercase(string $str): string
    {

        return Str::toUppercase($str);

    }
}

if (!function_exists('stringToLowercase')) {
    /**
     * @param string $str
     *
     * @return string
     */
    #[Pure]
    function stringToLowercase(string $str): string
    {

        return Str::toLowercase($str);

    }
}

if (!function_exists('stringRandom')) {
    /**
     * @param int $length
     *
     * @return string
     * @throws Exception
     */
    function stringRandom(int $length = 32): string
    {

        return Str::random($length);

    }
}

if (!function_exists('stringLength')) {
    /**
     * @param string      $str
     * @param string|null $encoding
     *
     * @return bool|int
     * @throws Exception
     */
    #[Pure]
    function stringLength(string $str, ?string $encoding = null): bool|int
    {

        return Str::length($str, $encoding);

    }
}

if (!function_exists('stringTrimToSymbol')) {
    /**
     * @param string $str
     * @param string $symbol
     * @param bool   $firstOccurrence
     *
     * @return string
     */
    #[Pure]
    function stringTrimToSymbol(string $str, string $symbol, bool $firstOccurrence = true): string
    {

        return Str::trimToSymbol($str, $symbol, $firstOccurrence);

    }
}

if (!function_exists('stringTrimAfterSymbol')) {
    /**
     * @param string $str
     * @param string $symbol
     * @param bool   $firstOccurrence
     *
     * @return string
     */
    #[Pure]
    function stringTrimAfterSymbol(string $str, string $symbol, bool $firstOccurrence = true): string
    {

        return Str::trimAfterSymbol($str, $symbol, $firstOccurrence);

    }
}