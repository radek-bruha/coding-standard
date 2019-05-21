# [PHP](https://php.net) Coding Standard
[![Downloads](https://img.shields.io/packagist/dt/radek-bruha/coding-standard.svg?style=flat-square)](https://packagist.org/packages/radek-bruha/coding-standard)
[![Build Status](https://img.shields.io/travis/radek-bruha/coding-standard.svg?style=flat-square)](https://travis-ci.org/radek-bruha/coding-standard)
[![Coverage Status](https://img.shields.io/coveralls/github/radek-bruha/coding-standard.svg?style=flat-square)](https://coveralls.io/github/radek-bruha/coding-standard)
[![Latest Stable Version](https://img.shields.io/github/release/radek-bruha/coding-standard.svg?style=flat-square)](https://github.com/radek-bruha/coding-standard/releases)

**Usage**
```
composer require radek-bruha/coding-standard
```

**[**PHPCodeSniffer**](https://github.com/squizlabs/PHP_CodeSniffer) Analyzer Usage**

```
vendor/bin/phpcs bin src tests -pvvv --extensions=php --standard=ruleset.xml | vendor/bin/phpcs-analyzer
```

```
015.000s (100.000%): Analyzed 100 000 rows of logs in 010.000s with 100.000MB RAM usage
005.000s (033.333%): SniffName
004.000s (026.666%): SniffName
003.000s (020.000%): SniffName
002.000s (013.333%): SniffName
001.000s (006.666%): SniffName
```

**[**PHPCodeSniffer**](https://github.com/squizlabs/PHP_CodeSniffer) & [**PHPStan**](https://github.com/phpstan/phpstan) & [**PHPUnit**](https://github.com/sebastianbergmann/phpunit) & [**PHPParaTest**](https://github.com/paratestphp/paratest) & [**PHPInfection**](https://github.com/infection/infection) Clean Unified Output Usage**

```
==================================================
|           STARTING FULL TEST BATTERY           |
==================================================

==================================================
|           RUNNING CODE STYLE CHECKER           |
==================================================

..................................................  50 / 100 ( 50%)
.................................................. 100 / 100 (100%)

==================================================
|   00:01:00.0000000   |  |   00:01:00.0000000   |
==================================================

==================================================
|          RUNNING CODE STATIC ANALYSIS          |
==================================================

..................................................  50 / 100 ( 50%)
.................................................. 100 / 100 (100%)

==================================================
|   00:01:00.0000000   |  |   00:02:00.0000000   |
==================================================

==================================================
|            RUNNING INTEGRATION TEST            |
==================================================

..................................................  50 / 200 ( 25%)
.................................................. 100 / 200 ( 50%)
.................................................. 150 / 200 ( 75%)
.................................................. 200 / 200 (100%)

==================================================
|   00:08:00.0000000   |  |   00:10:00.0000000   |
==================================================

==================================================
|             RUNNING INFECTION TEST             |
==================================================

..................................................  50 / 500 ( 10%)
.................................................. 100 / 500 ( 20%)
.................................................. 150 / 500 ( 30%)
.................................................. 200 / 500 ( 40%)
.................................................. 250 / 500 ( 50%)
.................................................. 300 / 500 ( 60%)
.................................................. 350 / 500 ( 70%)
.................................................. 400 / 500 ( 80%)
.................................................. 450 / 500 ( 90%)
.................................................. 500 / 500 (100%)

==================================================
|   00:10:00.0000000   |  |   00:20:00.0000000   |
==================================================

==================================================
|                00:20:00.0000000                |
==================================================
```