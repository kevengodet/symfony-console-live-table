<?php

require_once __DIR__ . '/vendor/autoload.php';

use Keven\Symfony\Console\LiveTable;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Example from the README.md
 */

$output = new ConsoleOutput();

$table = new LiveTable($output);
$table->setHeaders(['Status', 'Name', 'URL']);
$table->add(['<fg=red>✗</>', 'PHP', 'https://php.net']);
$league = $table->add(['<fg=green>✓</>', 'PHP League', 'https://thephpleague.com']);
$table->render();

sleep(1);

$table->append(['<fg=green>✓</>', 'Packagist', 'https://packagist.org'], 'packagist');

sleep(1);

$table->remove($league);
$table->remove('packagist');

sleep(1);

$table->clear();
