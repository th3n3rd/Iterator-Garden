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
use Traversable;
use EmptyIterator;
use IteratorIterator;

/**
 * Class TraversableDecorator.
 *
 * A Decorator Class for a Traversable (Iterator)
 *
 * Because Traversable can not be implemented in PHP Userspace, Iterator - which is a Traversable - is implemented.
 *
 * @package IteratorGarden
 */
class TraversableDecorator implements Iterator
{
    /**
     * @var Iterator
     */
    protected $traversable;

    /**
     * Constructor.
     *
     * @param Traversable $traversable (optional)
     */
    public function __construct(Traversable $traversable = NULL)
    {
        $traversable || $traversable = new EmptyIterator();

        $this->traversable =
            $traversable instanceof Iterator
                ? $traversable
                : new IteratorIterator($traversable);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->traversable->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->traversable->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->traversable->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->traversable->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->traversable->next();
    }
}
