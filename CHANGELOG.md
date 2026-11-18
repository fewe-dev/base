# Changelog

## 2.4.1

### Added

- `Variables::stringValueOrDefault()` converts a value into a string like `stringValue()`, but returns a default value
  (an empty string unless another one is passed) for values without a string representation: null, arrays and objects
  without `__toString()`. `stringValue()` keeps returning their `var_export()` code, for example `NULL` for null.
- Continuous integration: the unit tests run with PHP 7.4 to 8.5, PHPStan and PHP CS Fixer with PHP 8.4; a push to
  the main branch releases the version of `composer.json` when all checks pass.
