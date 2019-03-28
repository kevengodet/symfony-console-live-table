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

$table = new LiveTable;
$table->setHeadesr(['Status', 'Name', 'URL']);
$table->addRow(['<light_red>✗</light_red>', 'PHP', 'https://php.net']);
$table->addRow(['<light_green>✓</light_green>', 'PHP League', 'https://thephpleague.com']);
$table->render();

// Result in console:
// +---+------------+--------------------------+
// | ! | Name       | URL                      |
// +---+------------+--------------------------+
// | ✗ | PHP        | https://php.net          |
// | ✓ | PHP League | https://thephpleague.com |
// +---+------------+--------------------------+

// You can also choose the added row index:
$table->add(['<light_green>✓</light_green>', 'Packagist', 'https://packagist.org'], 'packagist');

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

// Clear all rows
$table->clear();

// Result in console:
// ---------------------------------------------
// | ! | Name       | URL                      |
// =============================================
// |   |            |                          |
// ---------------------------------------------

// Finally delete totally the table of the CLI
$table->delete();
```
