<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 1014 hakre <http://hakre.wordpress.com/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace IteratorGarden;
use Iterator;
use InvalidArgumentException;

/**
 * Class RangeIterator.
 *
 * The RangeIterator allows to iterate over a range of numbers, from low to high.
 *
 * @package IteratorGarden
 */
class RangeIterator implements Iterator
{
    /**
     * @var float|int
     */
    private $offset;

    /**
     * @var int
     */
    private $index;

    /**
     * @var float
     */
    private $length;

    /**
     * @var int
     */
    private $step;

    /**
     * Constructor.
     *
     * @param int|float $low
     * @param int|float $high
     * @param int       $step
     */
    public function __construct($low, $high, $step = NULL)
    {
        $low  = $this->inputArgumentNumeric('Low', $low);
        $high = $this->inputArgumentNumeric('High', $high);

        if ($step === NULL) {
            $step = 1;
        }
        if (!is_integer($step) and !is_float($step)) {
            throw new InvalidArgumentException(sprintf('Step must be integer or float, %s given', gettype($step)));
        }

        $this->offset = $low;

        $step         = abs($step);
        $this->length = floor(abs(($high - $low) / $step)) + 1;
        $this->step   = $low > $high ? -$step : $step;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->index < $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->offset + $this->index * $this->step;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->index < $this->length
        && $this->index++;
    }

    /**
     * Moves the cursor to the given position.
     *
     * @param int $position
     */
    public function seek($position)
    {
        $this->index = $position;
    }

    /**
     * Checks whether the given argument is numeric.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return float|int
     * @throws InvalidArgumentException
     */
    private function inputArgumentNumeric($name, $value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(sprintf("%s must be a number or a numeric string, %s given", $name, gettype($value)));
        }

        if (is_string($value)) {
            $int = (int)$value;
            return "$int" === $value ? (int)$value : (float)$value;
        }

        if (is_int($value)) {
            return $value;
        }

        return (float)$value;
    }
}
