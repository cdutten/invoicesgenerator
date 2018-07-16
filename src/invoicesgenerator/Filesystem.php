<?php
/**
 * Created by PhpStorm.
 * User: Cesar Dutten
 * Date: 18/6/2018
 * Time: 06:16
 */

namespace invoicesgenerator;

use invoicesgenerator\contracts\FilesystemInterface;

class Filesystem implements FilesystemInterface
{

    /**
     * Check if a $path is writable
     * @param $path
     * @return bool
     */
    public static function isWritable($path)
    {
        return is_writable($path);
    }

    /**
     * Check if a file exists
     *
     * @param $path
     * @return bool
     */
    public static function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Check if a given path is a directory
     *
     * @param  string  $directory
     * @return bool
     */
    public static function isDirectory($directory)
    {
        return is_dir($directory);
    }

    /**
     * Makes a directory
     *
     * @param $path
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    public static function makeDirectory($path, $mode = 0755, $recursive = false)
    {
        return mkdir($path);
    }

    /**
     * Deletes a file
     *
     * @param $paths
     * @return bool
     */
    public static function delete($paths)
    {
        $paths = is_array($paths) ? $paths : func_get_args();

        $response = false;
        foreach ($paths as $path) {
            $response = unlink($path);
        }
        return $response;
    }

    /**
     * Deletes a Directory and his files.
     * If the third param is true you can preserve the father directory
     *
     * @param $directory
     * @param bool $preserve
     * @return bool
     * @throws \Exception
     */
    public static function deleteDirectory($directory, $preserve = false)
    {
        if (!self::isDirectory($directory)) {
            throw new \Exception("This isn't a directory");
        }

        $items = new \FilesystemIterator($directory);
        foreach ($items as $item) {
            if ($item->isDir() && ! $item->isLink()) {
                self::deleteDirectory($item->getPathname());
            } else {
                self::delete($item->getPathname());
            }
        }

        if (! $preserve) {
            rmdir($directory);
        }

        return true;
    }

    /**
     * Empty the specified directory of all files and folders.
     *
     * @param $directory
     * @return bool
     * @throws \Exception
     */
    public static function cleanDirectory($directory)
    {
        return self::deleteDirectory($directory, true);
    }
}