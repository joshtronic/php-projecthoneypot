# php-projecthoneypot

[![Build Status](http://img.shields.io/travis/joshtronic/php-projecthoneypot.svg?style=flat)][travis]
[![Coverage Status](http://img.shields.io/coveralls/joshtronic/php-projecthoneypot.svg?style=flat)][coveralls]
[![Downloads](http://img.shields.io/packagist/dm/joshtronic/php-projecthoneypot.svg?style=flat)][packagist]
[![Gittip](http://img.shields.io/gittip/joshtronic.svg?style=flat)][gittip]

[travis]:    http://travis-ci.org/joshtronic/php-projecthoneypot
[coveralls]: https://coveralls.io/r/joshtronic/php-projecthoneypot
[packagist]: https://packagist.org/packages/joshtronic/php-projecthoneypot
[gittip]:    https://www.gittip.com/joshtronic/

PHP Wrapper for Project Honey Pot. Compatible with PHP 5.3+ and HHVM.

## Installation

The preferred installation method is via `composer`. First add the following to your `composer.json`

```json
"require": {
	"joshtronic/php-projecthoneypot": "dev-master"
}
```

Then run `composer update`

## Usage

### Getting Started

```php
require_once 'joshtronic/ProjectHoneyPot.php';
$php = new joshtronic\ProjectHoneyPot();
```

### Performing a Lookup

```php
$results = $php->query('1.2.3.4');
print_r($results);
```

### Results

Queries will return an array of information about the IP address. The array will contain `last_activity`, `threat_score` and an array of `categories`.

## Contributing

Suggestions and bug reports are always welcome, but karma points are earned for pull requests.

Unit tests are required for all contributions. You can run the test suite from the `tests` directory simply by running `phpunit .`
