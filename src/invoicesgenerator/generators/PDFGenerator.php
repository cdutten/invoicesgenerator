<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 13/6/2018
 * Time: 22:43
 */

namespace invoicesgenerator\generators;

use FilesystemIterator;
use invoicesgenerator\contracts\GeneratorInterface;

class PDFGenerator implements GeneratorInterface
{
    public function put($path, $content)
    {
        // TODO: Implement put() method.
    }

    public function isWritable($path)
    {
        return is_writable($path);
    }

    public function exists($path)
    {
        return file_exists($path);
    }

    public function isDirectory($directory)
    {
        return is_dir($directory);
    }

    public function makeDirectory($path)
    {
        return mkdir($path);
    }

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
