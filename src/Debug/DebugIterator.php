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

namespace IteratorGarden\Debug;

use IteratorIterator;
use RuntimeException;

/**
 * Class DebugIterator.
 *
 * @package IteratorGarden\Debug
 */
class DebugIterator extends IteratorIterator
{
    const MODE_NOTICE = 1;
    const MODE_ECHO   = 2;
    const MODE_STDERR = 3;

    /**
     * @var int
     */
    private $mode = self::MODE_ECHO;

    /**
     * @var int
     */
    private $index;

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->index = 0;
        $this->event(__FUNCTION__);
        parent::rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        $this->event(__FUNCTION__);
        return parent::valid();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $this->event(__FUNCTION__);
        return parent::current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        $this->event(__FUNCTION__);
        return parent::key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->index++;
        $this->event(__FUNCTION__);
        parent::next();
    }

    /**
     * Handles the given event.
     *
     * @param $event
     */
    final protected function event($event)
    {
        $message = sprintf("Iterating (%s): #%d %s", get_class($this->getInnerIterator()), $this->index, $event);

        switch ($this->mode) {
            case self::MODE_NOTICE:
                trigger_error($message);
                break;
            case self::MODE_ECHO:
                echo $message, "\n";
                break;
            case self::MODE_STDERR:
                fputs(STDERR, $message . "\n");
                break;
            default:
                throw new RuntimeException($message);
        }
    }
}
