# keven/symfony-console-live-table

Dynamically add and remove rows from a table in console.

## Install

```shell
$ composer require keven/symfony-console-live-table
```

## Usage

```php
<?php

use Keven\Symfony\Console\LiveTable;

$table = new LiveTable($output);
$table->setHeaders(['Status', 'Name', 'URL']);
$table->add(['<fg=red>✗</>', 'PHP', 'https://php.net']);
$league = $table->add(['<fg=green>✓</>', 'PHP League', 'https://thephpleague.com']);
$table->render();

// Result in console:
// +---+------------+--------------------------+
// | ! | Name       | URL                      |
// =============================================
// | ✗ | PHP        | https://php.net          |
// | ✓ | PHP League | https://thephpleague.com |
// +---+------------+--------------------------+

// You can also choose the added row index:
$table->append(['<fg=green>✓</>', 'Packagist', 'https://packagist.org'], 'packagist');

// Result in console:
// ---------------------------------------------
// | ! | Name       | URL                      |
// =============================================
// | ✗ | PHP        | https://php.net          |
// ---------------------------------------------
// | ✓ | PHP League | https://thephpleague.com |
// ---------------------------------------------
// | ✓ | Packagist  | https://packagist.org    |
// ---------------------------------------------

// Remove some rows
$table->remove($league);
$table->remove('packagist');

// Result in console:
// ---------------------------------------------
// | ! | Name       | URL                      |
// =============================================
// | ✗ | PHP        | https://php.net          |
// ---------------------------------------------

// Remove the table
$table->clear();

```
