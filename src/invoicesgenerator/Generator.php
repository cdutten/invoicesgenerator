<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 18/6/2018
 * Time: 06:16
 */

namespace invoicesgenerator;


use invoicesgenerator\contracts\GeneratorInterface;

abstract class Generator implements GeneratorInterface
{

    public function put($path, $content)
    {

    }

    /**
     * Check if a $path is writable
     * @param $path
     * @return bool
     */
    public function isWritable($path)
    {
        return is_writable($path);
    }

    /**
     * Check if a file exists
     *
     * @param $path
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Check if a given path is a directory
     *
     * @param  string  $directory
     * @return bool
     */
    public function isDirectory($directory)
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
    public function makeDirectory($path, $mode = 0755, $recursive = false)
    {
        return mkdir($path);
    }

    /**
     * Deletes a file
     *
     * @param $paths
     * @return bool
     */
    public function delete($paths)
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
    public function deleteDirectory($directory, $preserve = false)
    {
        if (!$this->isDirectory($directory)) {
            throw new \Exception("This isn't a directory");
        }

        $items = new FilesystemIterator($directory);
        foreach ($items as $item) {
            if ($item->isDir() && !$item->isLink()) {
                $this->deleteDirectory($item->getPathname());
            } else {
                $this->delete($item->getPathname());
            }
        }

        if (!$preserve){
            rmdir($directory);
        }

        return true;
    }

    /**
     * Empty the specified directory of all files and folders.
     *
     * @param $directory
     * @return bool
     */
    public function cleanDirectory($directory)
    {
        return $this->deleteDirectory($directory, true);
    }
}