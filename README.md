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
$php = new joshtronic\ProjectHoneyPot('_YOUR_API_KEY_');
```

### Performing a Lookup

```php
$results = $php->query('1.2.3.4');
print_r($results);
```

### Results

Queries will return an array of information about the IP address. The array will contain `last_activity`, `threat_score` and an array of `categories`.

### Simulating Results

The folks at Project Honey Pot were kind enough to include a way to simulate results from their http:BL API. You can do so by performing queries against the following IP addresses.

#### Visitor Types

* 127.1.1.0 - Search Engine
* 127.1.1.1 - Suspicious
* 127.1.1.2 - Harvester
* 127.1.1.3 - Suspicious & Harvester
* 127.1.1.4 - Comment Spammer
* 127.1.1.5 - Suspicious & Comment Spammer
* 127.1.1.6 - Harvester & Comment Spammer
* 127.1.1.7 - Suspicious & Harvester & Comment Spammer

#### Threat Levels

* 127.1.10.1 - Threat level 10
* 127.1.20.1 - Threat level 20
* 127.1.40.1 - Threat level 40
* 127.1.80.1 - Threat level 80

#### Number of Days

* 127.10.1.1 - 10 days since last seen
* 127.20.1.1 - 20 days since last seen
* 127.40.1.1 - 40 days since last seen
* 127.80.1.1 - 80 days since last seen

## Contributing

Suggestions and bug reports are always welcome, but karma points are earned for pull requests.

Unit tests are required for all contributions. You can run the test suite from the `tests` directory simply by running `phpunit .`

I also urge you to install a honey pot and donate some MX records to Project Honey Pot. They are doing great work, they provide http:BL as a free service and your donations help make their service ever better!

If you’re not already a member, please sign up today with [my referral code](http://www.projecthoneypot.org?rf=123193).
