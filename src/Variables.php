<?php

declare(strict_types=1);

namespace FeWeDev\Base;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2024-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Variables
{
    /**
     * @param mixed $value
     *
     * @phpstan-assert-if-false !=null $value
     */
    public function isEmpty($value): bool
    {
        if (null === $value) {
            return true;
        }

        if (is_string($value) && 0 === strlen(trim($value))) {
            return true;
        }

        if (is_array($value)) {
            return 0 === count($value);
        }

        if ($value instanceof \stdClass) {
            return 0 == count((array) $value);
        }

        return false;
    }

    /**
     * Returns the keys whose values differ between the old and the new data. A missing key has the value null, null
     * equals an empty string. Numbers are compared by value, booleans with numbers as 0 and not 0, strings
     * case-insensitively. Arrays and objects are not compared. The key "updated_at" is ignored.
     *
     * @param array<mixed, mixed> $oldData
     * @param array<mixed, mixed> $newData
     *
     * @return array<mixed, mixed>
     */
    public function getChangedData(array $oldData, array $newData): array
    {
        $changedAttributeCodes = [];

        foreach (array_keys($oldData + $newData) as $attributeCode) {
            if (0 === strcasecmp((string) $attributeCode, 'updated_at')) {
                continue;
            }

            if ($this->isValueChanged($oldData[$attributeCode] ?? null, $newData[$attributeCode] ?? null)) {
                $changedAttributeCodes[] = $attributeCode;
            }
        }

        return $changedAttributeCodes;
    }

    /**
     * @param mixed $value
     */
    public function stringValue($value): string
    {
        if (\is_scalar($value)) {
            $value = (string) $value;
        } elseif (\is_object($value) && method_exists($value, '__toString')) {
            $value = (string) $value->__toString();
        } else {
            $value = var_export($value, true);
        }

        return $value;
    }

    /**
     * Converts a value into a string like stringValue(), but returns the default value for values that have no string
     * representation (null, arrays and objects without __toString()) instead of their var_export() code, for example
     * "NULL" for null.
     *
     * @param mixed $value
     */
    public function stringValueOrDefault($value, string $defaultValue = ''): string
    {
        if (\is_scalar($value)) {
            return (string) $value;
        }

        if (\is_object($value) && method_exists($value, '__toString')) {
            return (string) $value->__toString();
        }

        return $defaultValue;
    }

    /**
     * Converts a value into an integer, for example an ID that Magento declares as int but returns as string.
     *
     * @param mixed $value
     *
     * @throws \InvalidArgumentException if the value is null or not scalar
     */
    public function intValue($value): int
    {
        if (!\is_null($value)) {
            if (\is_int($value)) {
                return $value;
            }
            if (\is_string($value) && \ctype_digit($value)) {
                return (int) $value;
            }
            if (\is_scalar($value)) {
                return intval($value);
            }
        }

        throw new \InvalidArgumentException(sprintf('Could not convert value: %s to int', var_export($value, true)));
    }

    /**
     * @param mixed $oldValue
     * @param mixed $newValue
     */
    private function isValueChanged($oldValue, $newValue): bool
    {
        if (null === $oldValue) {
            $oldValue = '';
        }

        if (null === $newValue) {
            $newValue = '';
        }

        if (!is_scalar($oldValue) || !is_scalar($newValue)) {
            return false;
        }

        if (is_bool($oldValue) || is_bool($newValue)) {
            if ((is_bool($oldValue) || is_numeric($oldValue)) && (is_bool($newValue) || is_numeric($newValue))) {
                return (0.0 != (float) $oldValue) !== (0.0 != (float) $newValue);
            }
        } elseif (is_numeric($oldValue) && is_numeric($newValue)) {
            return (float) $oldValue != (float) $newValue;
        }

        return 0 !== strcasecmp((string) $oldValue, (string) $newValue);
    }
}
