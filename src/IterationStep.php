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
use Exception;

/**
 * Class IterationStep.
 *
 * Represents a single iteration in an iteration.
 *
 * @package IteratorGarden
 */
class IterationStep
{
    /**
     * @var mixed
     */
    private $current;

    /**
     * @var mixed
     */
    private $key;

    /**
     * @var bool
     */
    private $valid;

    /**
     * Constructor.
     *
     * @param bool  $valid
     * @param mixed $current
     * @param mixed $key
     */
    public function __construct($valid, $current, $key)
    {
        $this->valid   = $valid;
        $this->current = $current;
        $this->key     = $key;
    }

    /**
     * Creates a new instance from the given iterator.
     *
     * @param Iterator $iterator
     *
     * @return IterationStep
     */
    public static function createFromIterator(Iterator $iterator)
    {
        $valid = NULL;

        try {
            $valid = $iterator->valid();
        } catch (Exception $e) {
        }

        if (!$valid) {
            return new self($valid, NULL, NULL);
        }

        return new self(
            $valid,
            $iterator->current(),
            $iterator->key()
        );
    }

    /**
     * Returns the current element.
     *
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Returns the key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Checks whether the current position is valid.
     *
     * @return bool
     */
    public function getValid()
    {
        return $this->valid;
    }
}
