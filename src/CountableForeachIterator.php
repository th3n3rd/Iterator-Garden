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

use ArrayIterator;
use ArrayObject;
use Countable;
use InvalidArgumentException;
use IteratorIterator;
use Traversable;

/**
 * Class CountableForeachIterator.
 *
 * @package IteratorGarden
 */
class CountableForeachIterator extends IteratorIterator implements Countable
{
    /**
     * Constructor.
     *
     * @param Traversable $traversable
     */
    public function __construct($traversable)
    {
        if (is_array($traversable)) {
            $iterator = new ArrayIterator($traversable);
        } elseif ($traversable instanceof Traversable) {
            $iterator = $traversable;
        } elseif (is_object($traversable)) {
            $iterator = new ArrayObject($traversable);
        } else {
            throw new InvalidArgumentException('Not an Array, Traversable or Object.');
        }

        parent::__construct($iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $inner = $this->getInnerIterator();
        if ($inner instanceof Countable) {
            return $inner->count();
        }

        return iterator_count($this);
    }
}
