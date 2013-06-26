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


class IteratorGardenUtil
{
    /**
     * @param string|string[] $baseDir
     */
    public static function autoloadRegister($baseDir)
    {
        $baseDir = array_values((array) $baseDir);
        foreach ($baseDir as $index => $directory) {
            $dir = $index ? $baseDir[0] . '/' . $directory : $directory;
            spl_autoload_register(function ($class) use ($dir) {
                $stub = pathinfo($class, PATHINFO_FILENAME);
                $path = sprintf($dir . '/%s.php', $stub);
                if (is_file($path)) {
                    require($path);
                }
            });
        }
    }
}

IteratorGardenUtil::autoloadRegister(array(
    __DIR__,
    'Debug',
    'Filter',
));
