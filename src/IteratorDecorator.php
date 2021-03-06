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

use OuterIterator;
use Iterator;

/**
 * Class IteratorDecorator.
 *
 * Iterator Decorator class that also allows to set the Iterator.
 *
 * @package IteratorGarden
 */
class IteratorDecorator extends TraversableDecorator implements OuterIterator
{
    /**
     * Constructor.
     *
     * @param Iterator $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->setInnerIterator($iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function getInnerIterator()
    {
        return $this->traversable;
    }

    /**
     * Sets the inner iterator.
     *
     * @param Iterator $iterator
     */
    public function setInnerIterator(Iterator $iterator)
    {
        $this->traversable = $iterator;
    }
}
