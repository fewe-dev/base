# Description

FeWeDev Base provides helping classes for all feasible web developments.

## Installation

```bash
$ composer require fewedev/base
```

## Converting values

`FeWeDev\Base\Variables` converts values of unknown type, for example from configurations, requests or databases:

- `stringValue($value)` returns scalars and objects with `__toString()` as string, other values as their
  `var_export()` code, for example `NULL` for null.
- `stringValueOrDefault($value, $defaultValue = '')` returns scalars and objects with `__toString()` as string, other
  values (null, arrays, objects without `__toString()`) as the default value; use it where a missing value must not
  become the text `NULL`.
- `intValue($value)` returns an integer and throws an `InvalidArgumentException` for values that cannot be converted.

## Development

```bash
composer test    # unit tests
composer ps      # PHPStan
composer cs      # PHP CS Fixer, without changes
```

The library supports PHP 7.4 and newer. The CI workflow runs the unit tests with every PHP version from 7.4 to 8.5 and
PHPStan and PHP CS Fixer with PHP 8.4, on every push and pull request. A push to the main branch releases the version
of `composer.json` (tag and GitHub release with the section of `CHANGELOG.md`) when all checks pass; Packagist picks up
the tag.

## License

FeWeDev Base is licensed under the MIT License - see the LICENSE file for details.
