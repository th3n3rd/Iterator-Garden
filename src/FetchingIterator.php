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

use InvalidArgumentException;
use Iterator;

/**
 * Class FetchingIterator.
 *
 * @package IteratorGarden
 */
class FetchingIterator implements Iterator
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var int
     */
    private $index;

    /**
     * @var mixed
     */
    private $current;

    /**
     * @var bool
     */
    private $valid;

    /**
     * @var mixed
     */
    private $stopValue;

    /**
     * Constructor.
     *
     * @param Callable $callback
     * @param mixed    $stopValue
     */
    public function __construct($callback, $stopValue = NULL)
    {
        if (!is_callable($callback, TRUE)) {
            throw new InvalidArgumentException('Invalid callback given.');
        }
        $this->callback = $callback;
        $this->stopValue = $stopValue;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->index = -1;
        $this->fetchNext();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->current;
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
        $this->fetchNext();
    }

    /**
     * Fetches the next element.
     *
     * @return void.
     */
    protected function fetchNext()
    {
        $this->index++;
        $this->valid = $this->stopValue !== $this->current = call_user_func($this->callback);
    }
}
