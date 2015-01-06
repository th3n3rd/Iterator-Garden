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

namespace IteratorGarden\Test;
use IteratorGarden\DualDirectoryIterator;
use FilesystemIterator;
use LogicException;
use UnexpectedValueException;
use Exception;

/**
 * @covers DualDirectoryIterator
 */
class DualDirectoryIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation() {
        $dual = new DualDirectoryIterator('.', '.');
        $this->assertInstanceOf('IteratorGarden\DualDirectoryIterator', $dual);
    }

    /**
     * @test
     */
    public function creationWithFilesystemIterator() {
        $iter = new FilesystemIterator('.');
        $dual = new DualDirectoryIterator($iter, '.');
        $this->assertInstanceOf('IteratorGarden\DualDirectoryIterator', $dual);
    }

    /**
     * @test
     * @expectedException LogicException
     */
    public function unrewound() {
        $dual = new DualDirectoryIterator('.', '.');
        $dual->current(); // current() w/o rewind()
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function invalidFileInfoClass() {
        $dual = new DualDirectoryIterator('.', '.');

        $this->addToAssertionCount(1);
        try {
            $dual->setInfoClass(null);
        } catch(Exception $e) {
            $this->fail('Exception on NULL is wrong');
        }

        $dual->setInfoClass('IteratorGarden\IteratorIterator');
    }

    /**
     * @test
     */
    public function fileInfoClass() {
        $dual = new DualDirectoryIterator('.', '.');

        $infoClass = 'IteratorGarden\FilesystemStubIterator';
        $dual->setInfoClass($infoClass);

        $dual->rewind();
        $first = $dual->current();
        $this->assertInstanceOf($infoClass, $first);

        list($a, $b) = $dual->getFileInfos();
        $this->assertInstanceOf($infoClass, $a);
        $this->assertInstanceOf($infoClass, $b);
        $this->assertEquals($a, $b);
    }
}
