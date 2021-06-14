<?php

namespace Codememory\Support;

/**
 * Class ConvertType
 * @package Codememory\Support\src
 *
 * @author  Codememory
 */
class ConvertType
{

    /**
     * @param string|int|float|null $value
     *
     * @return float|bool|int|string|null
     */
    public function auto(string|null|int|float $value): float|bool|int|string|null
    {

        if (is_string($value)) {
            if ('true' === $value) {
                return true;
            } elseif ('false' === $value) {
                return false;
            } elseif (preg_match('/^[0-9]+$/', $value)) {
                return (int) $value;
            } elseif (preg_match('/^[0-9]*[.,][0-9]+$/', $value)) {
                return (float) $value;
            } elseif(empty($value)) {
                return null;
            }

            return $value;
        }

        return $value;

    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function inArray(array &$data): ConvertType
    {

        foreach ($data as &$value) {
            if (is_array($value)) {
                $this->inArray($value);
            } else {
                $value = $this->auto($value);
            }
        }

        return $this;

    }

    /**
     * @param string $json
     *
     * @return $this
     */
    public function inJson(string &$json): ConvertType
    {

        $json = json_decode($json);

        return $this->inArray($json);

    }

}