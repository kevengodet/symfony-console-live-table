<?php

namespace Keven\Symfony\Console;

use Symfony\Component\Console\Output\OutputInterface;

final class LiveTable
{
    /** @var OutputInterface */
    private $output;

    /** @var array */
    private $headers;

    /** @var array */
    private $rows;

    /** @var string[] */
    private $lastRender = [];

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Populate table, but do not render.
     *
     * @param array $rows
     * @return $this
     */
    public function setRows(array $rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Add a row to table without rendering.
     *
     * @param array $row
     * @param null|int|string $index
     * @return string|int
     */
    public function add(array $row, $index = null)
    {
        if (null === $index) {
            $this->rows[] = $row;
            $index = array_key_last($this->rows);
        } else {
            $this->rows[$index] = $row;
        }

        return $index;
    }

    /**
     * Add a row to table, then render.
     *
     * @param array $row
     * @param null|int|string $index
     * @return string|int
     */
    public function append(array $row, $index = null)
    {
        $index = $this->add($row, $index);

        $this->render();

        return $index;
    }

    /**
     * Remove a row from the table, then render.
     *
     * @param string|int $index
     */
    public function remove($index)
    {
        if (!isset($this->rows[$index])) {
            return;
        }

        unset($this->rows[$index]);
        $this->render();
    }

    public function render()
    {
        $this->clear();

        $widths = array_map(function($s) { return mb_strlen($s) + 2; }, $this->headers);

        foreach ($this->rows as $row) {
            $n = 0;
            foreach ($row as $cell) {
                if (mb_strlen($cell) + 2 > $widths[$n]) {
                    $widths[$n] = mb_strlen($cell) + 2;
                }
                $n++;
            }
        }

        $lines = [
            $this->renderLine($widths),
            $this->renderRow($this->headers, $widths),
            $this->renderLine($widths),
        ];

        foreach ($this->rows as $row) {
            $lines[] = $this->renderRow($row, $widths);
        }
        $lines[] = $this->renderLine($widths);

        $this->lastRender = $lines;

        $this->output->writeln(implode("\n", $lines));
    }

    private function clear()
    {
        foreach ($this->lastRender as $line) {
            $this->output->write("\r\033[K\033[1A\r\033[K\r");
        }
    }

    private function renderLine(array $width)
    {
        $segments = [];
        foreach ($width as $length) {
            $segments[] = str_repeat('-', $length + 2);
        }

        return '+' . implode('+', $segments) . '+';
    }

    private function renderRow(array $row, array $width)
    {
        $segments = [];
        $n = 0;
        foreach ($row as $cell) {
            $segments[] = str_pad($cell, $width[$n++]);
        }

        return '| '.implode(' | ', $segments). ' |';
    }
}

if ( ! function_exists( 'array_key_last' ) ) {
    /**
     * Polyfill for array_key_last() function added in PHP 7.3.
     *
     * Get the last key of the given array without affecting
     * the internal array pointer.
     *
     * @param array $array An array
     *
     * @return mixed The last key of array if the array is not empty; NULL otherwise.
     */
    function array_key_last( $array ) {
        $key = NULL;
        if ( is_array( $array ) ) {
            end( $array );
            $key = key( $array );
        }
        return $key;
    }
}
