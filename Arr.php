<?php

namespace Codememory\Support;

use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Class Arr
 * @package System\Support
 *
 * @author  Codememory
 */
class Arr
{

    /**
     * @var array
     */
    private static array $data = [];

    /**
     * @param array $data
     *
     * @return Arr
     */
    public static function set(array $data): Arr
    {

        self::$data = $data;

        return new self();

    }

    /**
     * @param array $than
     * @param array ...$withWhom
     *
     * @return bool
     */
    public static function share(array $than, array &...$withWhom): bool
    {

        foreach ($than as $key => $item) {
            foreach ($withWhom as &$arr) {
                $arr[$key] = $item;
            }
        }

        return true;

    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    #[Pure] public static function get(string $key): mixed
    {

        $data = self::$data;
        $keys = explode('.', $key);

        foreach ($keys as $key) {
            if (is_array($data) && array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                $data = null;
            }
        }

        return $data;

    }

    /**
     * @param string ...$keys
     *
     * @return array
     */
    #[Pure] public static function select(string ...$keys): array
    {

        $data = [];

        foreach ($keys as $key) {
            $data = array_merge($data, self::get($key));
        }

        return $data;

    }

    /**
     * @param array  $data
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public static function add(array &$data, string $key, mixed $value): bool
    {

        $data[$key] = $value;

        return true;

    }

    /**
     * @param array  $data
     * @param string $key
     *
     * @return bool
     */
    public static function exists(array $data, string $key): bool
    {

        $keys = explode('.', $key);
        $exists = false;

        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $data = $data[$key];

                $exists = true;
            } else {
                $exists = false;
            }
        }

        return $exists;

    }

    /**
     * @param array ...$arrays
     *
     * @return array
     */
    public static function intoOne(array ...$arrays): array
    {

        $data = [];

        foreach ($arrays as $arr) {
            foreach ($arr as $key => $item) {
                if (self::exists($data, $key)) {
                    $data[] = $item;
                } else {
                    $data[$key] = $item;
                }
            }
        }

        return $data;

    }

    /**
     * @param array  $data
     * @param string $key
     *
     * @return mixed
     */
    public static function pull(array &$data, string $key): mixed
    {

        $keys = explode('.', $key);
        $first = $keys[array_key_last($keys)];
        self::set($data);

        $received = self::get($key);

        unset($data[$first]);

        return $received;

    }

    /**
     * @param array $processedArray
     * @param array $renameKeys
     *
     * @return array
     */
    private static function strictRename(array $processedArray, array $renameKeys = []): array
    {

        $recycledArray = [];

        if ([] !== $renameKeys) {
            foreach ($renameKeys as $oldKey => $newKey) {
                foreach ($processedArray as $key => $item) {
                    if ($key === $oldKey) {
                        $recycledArray[$newKey] = $item;
                    } else {
                        $recycledArray[$key] = $item;
                    }
                }
            }
        } else {
            $recycledArray = $processedArray;
        }

        return $recycledArray;

    }

    /**
     * @param array $schema
     * @param array $processed
     * @param bool  $removeElements
     * @param array $renameKeys
     *
     * @return bool
     */
    public static function strictArray(array $schema, array &$processed, bool $removeElements = false, array $renameKeys = []): bool
    {

        $processedArray = [];

        if ($removeElements) {
            foreach ($processed as $key => $value) {
                if (false === self::exists($schema, $key)) {
                    unset($processed[$key]);
                }
            }
        }

        foreach ($schema as $key => $value) {
            if (self::exists($processed, $key)) {
                $processedArray[$key] = empty($processed[$key]) ? $value : $processed[$key];
            } else {
                $processedArray[$key] = $value;
            }
        }

        if (false === $removeElements) {
            foreach ($processed as $key => $value) {
                if (false === self::exists($processedArray, $key)) {
                    $processedArray[$key] = $value;
                }
            }
        }

        $processed = self::strictRename($processedArray, $renameKeys);

        return true;

    }

    /**
     * @param array $array
     * @param array $comparisonArray
     * @param array $values
     *
     * @return array
     */
    public static function arrayDiffKeyAdding(array $array, array $comparisonArray, array $values = []): array
    {

        foreach ($comparisonArray as $keyComp => $valueComp) {
            if (false === self::exists($array, $keyComp)) {
                $array[$keyComp] = $values[$keyComp] ?? null;
            }
        }

        return $array;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Converts from a multidimensional array to an ordinary one and
     * the key of each element separated by separator is the keys
     * that were in a multidimensional array
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array  $data
     * @param string $separator
     *
     * @return array
     */
    public static function dot(array $data, string $separator = '.'): array
    {

        return self::handlerDot($data, null, $separator);

    }

    /**
     * @param array $data
     *
     * @return array
     */
    public static function wholeKeys(array $data): array
    {

        $newData = [];

        foreach ($data as $value) {
            $newData[] = $value;
        }

        return $newData;

    }

    /**
     * @param array $where
     * @param mixed $addedData
     * @param int   $position
     *
     * @return array
     * @throws Exception
     */
    public static function addToPosition(array $where, mixed $addedData, int $position): array
    {

        $data = [];
        $currentPosition = 0;

        foreach ($where as $index => $value) {
            ++$currentPosition;

            if ($currentPosition === $position) {
                $data[Str::random(5)] = $addedData;
            }

            $data[$index] = $value;
        }

        return $data;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Adds a value after each element
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $where
     * @param mixed $insertData
     *
     * @return array
     * @throws Exception
     */
    public static function addAfterEach(array $where, mixed $insertData): array
    {

        $data = [];

        foreach ($where as $index => $value) {
            $data[$index] = $value;
            $data[Str::random(5)] = $insertData;
        }

        return $data;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Adds a value before each element
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $where
     * @param mixed $insertData
     *
     * @return array
     * @throws Exception
     */
    public static function addBeforeEach(array $where, mixed $insertData): array
    {

        $data = [];

        foreach ($where as $index => $value) {
            $data[Str::random(5)] = $insertData;
            $data[$index] = $value;
        }

        return $data;

    }

    /**
     * @param array $data
     * @param       ...$arrays
     *
     * @return array
     */
    public static function merge(array &$data, ...$arrays): array
    {

        foreach ($arrays as $array) {
            $data = array_merge($data, is_array($array) ? $array : [$array]);
        }

        return $data;

    }

    /**
     * @param array       $data
     * @param string|null $prepend
     * @param string      $separator
     *
     * @return array
     */
    private static function handlerDot(array $data, ?string $prepend = null, string $separator = '.'): array
    {

        $results = [];

        foreach ($data as $key => $item) {
            if (is_array($item) && false === empty($item)) {
                $results = array_merge($results, self::handlerDot($item, $prepend . $key . $separator));
            } else {
                $results[$prepend . $key] = $item;
            }
        }

        return $results;

    }

}