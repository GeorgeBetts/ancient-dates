# PHP Ancient Dates
A helper to format and get info from ancient and prehistoric dates for PHP.

When working with dates in code they typically follow the ISO 8601 date format (YYYY-MM-DD). This standard means BCE
dates are represented with a minus sign before the year (e.g., -3000-01-01).

Typically date formatters will ignore the minus and it's up to you to format the date appropriately.

Normally, a user would expect to see these dates in a more readable format, such as `3000 BCE`, or `5025 years ago`

This package helps you convert ancient dates to these formats and provides additional information such as the geological period.

## Installation
Install the package via composer:  
```bash
composer require gbetts/ancient-dates
```
## Usage
Initialise your date using the `AncientDate` class
```php
use Gbetts\AncientDates\AncientDate

$date = new AncientDate('-155000000-01-01T00:00:00Z');
```
The following methods are available for the date object:
```php
$date->toBceString() // 155 million years BCE
$date->yearsAgo() // 155002025
$date->period() // Jurassic
```
