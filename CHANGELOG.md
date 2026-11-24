# Changelog

## 2.4.3

### Fixed

- `Variables::getChangedData()` returned keys that exist only in one of the data arrays also when their value is null
  or an empty string, for example the empty attributes that Magento adds to products while saving them. A missing key
  counts as null.

## 2.4.2

### Fixed

- `Variables::getChangedData()` returned the value instead of the key of changed booleans, and missed keys that exist
  only in the new data and values that changed from or to null. It compares booleans with numbers as 0 and not 0, also
  for numeric strings like "0", treats null like an empty string, and ignores `updated_at` also when the old data is
  empty.

## 2.4.1

### Added

- `Variables::stringValueOrDefault()` converts a value into a string like `stringValue()`, but returns a default value
  (an empty string unless another one is passed) for values without a string representation: null, arrays and objects
  without `__toString()`. `stringValue()` keeps returning their `var_export()` code, for example `NULL` for null.
- Continuous integration: the unit tests run with PHP 7.4 to 8.5, PHPStan and PHP CS Fixer with PHP 8.4; a push to
  the main branch releases the version of `composer.json` when all checks pass.
