<?php

use Keven\Symfony\Console\LiveTable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class LiveTableTest extends TestCase
{
    public function testLiveTable()
    {
        $output = $this->createMock(OutputInterface::class);

        $table = new LiveTable($output);
        $table->setHeaders(['A', 'B', 'C']);
        $table->setRows([[1, 2, 3], [1, 2, 3]]);
        $table->add([1, 2, 3], 1);
        $table->render();
        $table->append([1, 2, 3], 2);
        $table->remove(2);

        $this->assertTrue(true, 'No exception thrown.');
    }
}
