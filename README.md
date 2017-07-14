[![Build Status](https://travis-ci.org/edsonmedina/php_testability.svg?branch=master)](https://travis-ci.org/edsonmedina/php_testability/)
[![Code Climate](https://codeclimate.com/github/edsonmedina/php_testability/badges/gpa.svg)](https://codeclimate.com/github/edsonmedina/php_testability)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/edsonmedina/php_testability/master.svg)](https://scrutinizer-ci.com/g/edsonmedina/php_testability/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/edsonmedina/php_testability/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/edsonmedina/php_testability/?branch=master)
[![Dependencies](https://www.versioneye.com/user/projects/54edb0b5672cff12e900000f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54edb0b5672cff12e900000f)

# PHP_Testability

Analyses and produces a report with testability issues of a php codebase.

## Installation
PHP_Testability requires at least PHP 7.0 to run.

### Composer 

Add `edsonmedina/php_testability` as a dependency to your project's `composer.json` file if you use [Composer](http://getcomposer.org/) to manage the dependencies of your project. 

```json
{
    "require-dev": {
        "edsonmedina/php_testability": "dev-master"
    }
}
```

And run `composer update`.

Or alternatively, just run:

```bash
composer require edsonmedina/php_testability "dev-master"
```

# Usage

Analyse the current directory and generate an HTML report into report/

```bash
vendor/bin/testability . -o report
```

Exclude some directories

```bash
vendor/bin/testability . -x vendor,tmp,upload,config -o report
```

Check all the available options.

```bash
vendor/bin/testability --help
```


# Results

Open report/index.html on your browser. You shoule see something like this:

![Screenshot](http://www.cianeto.com/testability_dir.png)

If you click on a file with issues, it'll show you a code browser and will highlight the lines with issues.

![Screenshot](http://www.cianeto.com/testability_file.png)


These are issues that hinder testability, such as:
* references to global variables, super globals, etc
* calls to functions that can't be mocked (like static methods or global functions)
* `new` instances of objects (tight coupling - can't be mocked/injected)
* ...and much more

Kudos to the brilliant [PHP-Parser](https://github.com/nikic/PHP-Parser/) (by nikic) on which PHP_Testability relies heavily.

