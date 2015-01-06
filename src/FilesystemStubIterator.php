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

use FilesystemIterator;
use SplFileInfo;

/**
 * Class FilesystemStubIterator.
 *
 * A FilesystemIterator of which the directory must not exists.
 *
 * @todo Refactor out an SplFileInfo decorator because the DualDirectoryIterator within its current path of
 *       inheritance is a FilesystemIterator -> DirectoryIterator -> SplFileInfo as well as which it yet
 *       does not qualify. This could delegate some boilerplate code into the decorator, too.
 *
 * @package IteratorGarden
 */
class FilesystemStubIterator extends FilesystemIterator
{
    /**
     * @var int
     */
    private $flags;

    /**
     * @var string
     */
    private $path;

    /**
     * @var
     */
    private $fileInfo;

    /**
     * Constructor.
     *
     * @param string $path
     * @param int    $flags
     */
    public function __construct($path, $flags = NULL)
    {
        if ($flags === NULL) {
            $flags = self::KEY_AS_PATHNAME | self::CURRENT_AS_FILEINFO | self::SKIP_DOTS;
        }

        $this->path  = $path;
        $this->flags = $flags;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    /**
     * {@inheritdoc}
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * {@inheritdoc}
     */
    public function setFlags($flags = NULL)
    {
        $this->flags = $flags;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilename()
    {
        return basename($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function getFileInfo($class_name = NULL)
    {
        if ($this->fileInfo) {
            return $this->fileInfo;
        }

        $info = new SplFileInfo($this->path);

        if ($class_name !== NULL) {
            $info = $info->getFileInfo($class_name);
        }

        return $this->fileInfo = $info;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return dirname($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function getPathname()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerms()
    {
        return $this->getFileInfo()->getPerms();
    }

    /**
     * {@inheritdoc}
     */
    public function getInode()
    {
        return $this->getFileInfo()->getInode();
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->getFileInfo()->getSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->getFileInfo()->getOwner();
    }

    /**
     * {@inheritdoc}
     */
    public function getGroup()
    {
        return $this->getFileInfo()->getGroup();
    }

    /**
     * {@inheritdoc}
     */
    public function getATime()
    {
        return $this->getFileInfo()->getATime();
    }

    /**
     * {@inheritdoc}
     */
    public function getMTime()
    {
        return $this->getFileInfo()->getMTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getCTime()
    {
        return $this->getFileInfo()->getCTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->getFileInfo()->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return $this->getFileInfo()->isWritable();
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
        return $this->getFileInfo()->isReadable();
    }

    /**
     * {@inheritdoc}
     */
    public function isFile()
    {
        return $this->getFileInfo()->isFile();
    }

    /**
     * {@inheritdoc}
     */
    public function isDir()
    {
        return $this->getFileInfo()->isDir();
    }

    /**
     * {@inheritdoc}
     */
    public function isLink()
    {
        return $this->getFileInfo()->isLink();
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkTarget()
    {
        return $this->getFileInfo()->getLinkTarget();
    }

    /**
     * {@inheritdoc}
     */
    public function getRealPath()
    {
        return $this->getFileInfo()->getRealPath();
    }

    /**
     * {@inheritdoc}
     */
    public function isExecutable()
    {
        return $this->getFileInfo()->isExecutable();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getBasename($suffix = NULL)
    {
        return $this->getFileInfo()->getBasename($suffix);
    }

    /**
     * {@inheritdoc}
     */
    public function getPathInfo($class_name = NULL)
    {
        if ($class_name === NULL) {
            return $this->getFileInfo()->getPathInfo();
        }

        return $this->getFileInfo()->getPathInfo($class_name);
    }

    /**
     * {@inheritdoc}
     */
    public function openFile($open_mode = 'r', $use_include_path = FALSE, $context = NULL)
    {
        if ($context === NULL) {
            return $this->getFileInfo()->openFile($open_mode, $use_include_path);
        }

        return $this->getFileInfo()->openFile($open_mode, $use_include_path, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return FALSE;
    }
}
