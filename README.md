# php-projecthoneypot [![Build Status](https://travis-ci.org/joshtronic/php-projecthoneypot.svg)](https://travis-ci.org/joshtronic/php-projecthoneypot) [![Coverage Status](https://coveralls.io/repos/joshtronic/php-projecthoneypot/badge.png)](https://coveralls.io/r/joshtronic/php-projecthoneypot)

PHP Wrapper for Project Honey Pot

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
