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

use IteratorIterator;
use Traversable;

/**
 * Class FullCachingIterator.
 *
 * Iterator that caches up to a whole iteration while iterating
 *
 * In difference to CachingIterator:
 *
 *  - Keeps a cache of data and state: current, key and valid.
 *  - Does not rewind (like NoRewindIterator)
 *  - Accepts any kind of key values incl. those that lead to data-loss
 *    with CachingIterator.
 *
 * @package IteratorGarden
 */
class FullCachingIterator extends IteratorIterator
{
    /**
     * @var int|NULL
     */
    private $index;

    /**
     * @var IterationStep[]
     */
    private $steps;

    /**
     * @var IterationStep
     */
    private $cache;

    /**
     * Constructor.
     *
     * @param Traversable $iterator
     */
    public function __construct(Traversable $iterator)
    {
        parent::__construct($iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if (!isset($this->index)) {
            parent::rewind();
            $this->steps[0] = IterationStep::createFromIterator($this->getInnerIterator());
        }
        $this->cache = $this->steps[$this->index = 0];
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->cache->getValid();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->cache->getCurrent();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->cache->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $index = ++$this->index;
        if (!isset($this->steps[$index])) {
            parent::next();
            $this->steps[$index] = IterationStep::createFromIterator($this->getInnerIterator());
        }
        $this->cache = $this->steps[$index];
    }
}
